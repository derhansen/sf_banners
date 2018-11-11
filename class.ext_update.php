<?php

use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Update class for the extension manager.
 */
class ext_update
{
    const BANNER_CATEGORY_TABLE = 'tx_sfbanners_domain_model_category';
    const BANNER_CATEGORY_MM_TABLE = 'tx_sfbanners_domain_model_banner_category_mm';

    /**
     * Array of flash messages (params) array[][status,title,message]
     *
     * @var array
     */
    protected $messageArray = [];

    /**
     * Main update function called by the extension manager.
     *
     * @return string
     */
    public function main()
    {
        $this->processUpdates();

        return $this->generateOutput();
    }

    /**
     * Returns if the update menu entry in EM should be shown.
     *
     * @return bool
     */
    public function access()
    {
        return true;
    }

    /**
     * The actual update function. Add your update task in here.
     *
     * @return void
     */
    protected function processUpdates()
    {
        $this->migrateBannerCategoriesToSysCategories();
    }

    /**
     * Generates output by using flash messages
     *
     * @return string
     */
    protected function generateOutput()
    {
        $output = '';
        foreach ($this->messageArray as $messageItem) {
            $output .= $this->getFlashMessage($messageItem[2], $messageItem[1], $messageItem[0]);
        }

        return $output;
    }

    /**
     * Migrates old banner categories to sys_categories if required
     *
     * @return void
     */
    protected function migrateBannerCategoriesToSysCategories()
    {
        // check if tx_sfbanners_domain_model_category still exists
        if (!$this->checkIfTableExists(self::BANNER_CATEGORY_TABLE)) {
            $status = FlashMessage::NOTICE;
            $title = '';
            $message = 'Old category table does not exist anymore so no update needed';
            $this->messageArray[] = [$status, $title, $message];

            return;
        }

        $oldCategoryTableFields = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::BANNER_CATEGORY_TABLE)
            ->getSchemaManager()
            ->listTableColumns(self::BANNER_CATEGORY_TABLE);

        // check if there are categories present else no update is needed
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::BANNER_CATEGORY_TABLE);
        $queryBuilder->getRestrictions()
            ->removeAll()
            ->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $oldCategoryCount = $queryBuilder
            ->count('uid')
            ->from(self::BANNER_CATEGORY_TABLE)
            ->execute()
            ->fetchColumn(0);

        if ($oldCategoryCount === 0) {
            $status = FlashMessage::NOTICE;
            $title = '';
            $message = 'No categories found in old table, no update needed';
            $this->messageArray[] = [$status, $title, $message];

            return;
        }
        $status = FlashMessage::NOTICE;
        $title = '';
        $message = 'Must migrate ' . $oldCategoryCount . ' categories.';
        $this->messageArray[] = [$status, $title, $message];

        // A temporary migration column is needed in old category table. Add this when not already present
        if (!array_key_exists('migrate_sys_category_uid', $oldCategoryTableFields)) {
            $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable(self::BANNER_CATEGORY_TABLE);
            $connection->query(
                "ALTER TABLE tx_sfbanners_domain_model_category ADD migrate_sys_category_uid int(11) DEFAULT '0' NOT NULL"
            );
        }

        // convert tx_sfbanners_domain_model_category records
        $this->migrateBannerCategoryRecords();

        // set/update all relations
        $oldNewCategoryUidMapping = $this->getOldNewCategoryUidMapping();
        $this->updateParentFieldOfMigratedCategories($oldNewCategoryUidMapping);
        $this->migrateCategoryMmRecords($oldNewCategoryUidMapping);

        $this->updateFlexformCategories('sfbanners_pi1', $oldNewCategoryUidMapping, 'settings.category');

        /**
         * Finished category migration
         */
        $message = 'All categories are updated. Run <strong>DB compare</strong> in the install tool to remove the ' .
            'now obsolete `tx_sfbanners_domain_model_category` and `tx_sfbanners_domain_model_banner_category_mm` tables and ' .
            'run the <strong>DB check</strong> to update the reference index.';
        $status = FlashMessage::OK;
        $title = 'Updated all categories!';
        $this->messageArray[] = [$status, $title, $message];
    }

    /**
     * Process not yet migrated tx_sfbanners_domain_model_category records to sys_category records
     *
     * @return void
     */
    protected function migrateBannerCategoryRecords()
    {
        // migrate default language category records
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::BANNER_CATEGORY_TABLE);
        $queryBuilder->getRestrictions()
            ->removeAll();

        $rows = $queryBuilder
            ->select('uid', 'pid', 'tstamp', 'crdate', 'cruser_id', 'starttime', 'endtime', 'sorting', 'sys_language_uid', 'l10n_parent', 'l10n_diffsource', 'title')
            ->from(self::BANNER_CATEGORY_TABLE)
            ->where(
                $queryBuilder->expr()->eq('migrate_sys_category_uid', 0),
                $queryBuilder->expr()->eq('sys_language_uid', 0),
                $queryBuilder->expr()->eq('deleted', 0)
            )
            ->execute();

        // Create a new sys_category record for each found record in default language, then
        $newCategoryRecords = 0;
        $oldNewDefaultLanguageCategoryUidMapping = [];
        foreach ($rows as $row) {
            $oldUid = $row['uid'];

            // Unset some columns
            unset($row['uid']);

            if (is_null($row['l10n_diffsource'])) {
                $row['l10n_diffsource'] = '';
            }

            $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
            $databaseConnectionForSysCategory = $connectionPool->getConnectionForTable('sys_category');
            $rowsInserted = $databaseConnectionForSysCategory->insert(
                'sys_category',
                $row
            );

            if ($rowsInserted === 1) {
                $newUid = (int)$databaseConnectionForSysCategory->lastInsertId('sys_category');
                $oldNewDefaultLanguageCategoryUidMapping[$oldUid] = $newUid;
                    $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                        ->getConnectionForTable(self::BANNER_CATEGORY_TABLE);
                    $connection->update(
                        self::BANNER_CATEGORY_TABLE,
                        ['migrate_sys_category_uid' => $newUid],
                        ['uid' => (int)$oldUid]
                    );
                $newCategoryRecords++;
            }
        }

        // migrate non-default language category records
        $rows = $queryBuilder
            ->select('uid', 'pid', 'tstamp', 'crdate', 'cruser_id', 'starttime', 'endtime', 'sorting', 'sys_language_uid', 'l10n_parent', 'l10n_diffsource', 'title')
            ->from(self::BANNER_CATEGORY_TABLE)
            ->where(
                $queryBuilder->expr()->eq('migrate_sys_category_uid', 0),
                $queryBuilder->expr()->neq('sys_language_uid', 0),
                $queryBuilder->expr()->eq('deleted', 0)
            )
            ->execute();

        foreach ($rows as $row) {
            $oldUid = $row['uid'];

            // Unset some columns
            unset($row['uid']);

            if (is_null($row['l10n_diffsource'])) {
                $row['l10n_diffsource'] = '';
            }
            // set l10n_parent if category is a localized version
            if (array_key_exists($row['l10n_parent'], $oldNewDefaultLanguageCategoryUidMapping)) {
                $row['l10n_parent'] = $oldNewDefaultLanguageCategoryUidMapping[$row['l10n_parent']];
            }

            $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
            $databaseConnectionForSysCategory = $connectionPool->getConnectionForTable('sys_category');
            $rowsInserted = $databaseConnectionForSysCategory->insert(
                'sys_category',
                $row
            );

            if ($rowsInserted === 1) {
                $newUid = (int)$databaseConnectionForSysCategory->lastInsertId('sys_category');
                $oldNewDefaultLanguageCategoryUidMapping[$oldUid] = $newUid;
                $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                    ->getConnectionForTable(self::BANNER_CATEGORY_TABLE);
                    $connection->update(
                        self::BANNER_CATEGORY_TABLE,
                        ['migrate_sys_category_uid' => $newUid],
                        ['uid' => (int)$oldUid]
                    );
                $newCategoryRecords++;
            }
        }
        $message = 'Created ' . $newCategoryRecords . ' sys_category records';
        $status = FlashMessage::INFO;
        $title = '';
        $this->messageArray[] = [$status, $title, $message];
    }

    /**
     * Create a mapping array of old->new category uids
     *
     * @return array
     */
    protected function getOldNewCategoryUidMapping()
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::BANNER_CATEGORY_TABLE);
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder
            ->select('uid', 'migrate_sys_category_uid')
            ->from(self::BANNER_CATEGORY_TABLE)
            ->where(
                $queryBuilder->expr()->gt('migrate_sys_category_uid', 0)
            )
            ->execute();

        $oldNewCategoryUidMapping = [];
        foreach ($rows as $row) {
            $oldNewCategoryUidMapping[$row['uid']] = $row['migrate_sys_category_uid'];
        }

        return $oldNewCategoryUidMapping;
    }

    /**
     * Update parent column of migrated categories
     *
     * @param array $oldNewCategoryUidMapping
     * @return void
     */
    protected function updateParentFieldOfMigratedCategories(array $oldNewCategoryUidMapping)
    {
        $updatedRecords = 0;

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::BANNER_CATEGORY_TABLE);
        $queryBuilder->getRestrictions()->removeAll();
        $toUpdate = $queryBuilder
            ->select('uid', 'parent')
            ->from(self::BANNER_CATEGORY_TABLE)
            ->where(
                $queryBuilder->expr()->gt('parent', 0)
            )
            ->execute();

        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::BANNER_CATEGORY_TABLE);

        foreach ($toUpdate as $row) {
            if (!empty($oldNewCategoryUidMapping[$row['parent']])) {
                $sysCategoryUid = $oldNewCategoryUidMapping[$row['uid']];
                $newParentUId = $oldNewCategoryUidMapping[$row['parent']];
                $connection->update(
                    'sys_category',
                    ['parent' => $newParentUId],
                    ['uid' => (int)$sysCategoryUid]
                );
                $updatedRecords++;
            }
        }
        $message = 'Set for ' . $updatedRecords . ' sys_category records the parent field';
        $status = FlashMessage::INFO;
        $title = '';
        $this->messageArray[] = [$status, $title, $message];
    }

    /**
     * Create new category MM records
     *
     * @param array $oldNewCategoryUidMapping
     * @return void
     */
    protected function migrateCategoryMmRecords(array $oldNewCategoryUidMapping)
    {
        $newMmCount = 0;

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(self::BANNER_CATEGORY_TABLE);
        $queryBuilder->getRestrictions()->removeAll();
        $oldMmRecords = $queryBuilder
            ->select('uid_local', 'uid_foreign', 'sorting')
            ->from(self::BANNER_CATEGORY_MM_TABLE)
            ->execute();

        foreach ($oldMmRecords as $oldMmRecord) {
            $oldCategoryUid = $oldMmRecord['uid_foreign'];
            if (!empty($oldNewCategoryUidMapping[$oldCategoryUid])) {
                $newMmRecord = [
                    'uid_local' => $oldNewCategoryUidMapping[$oldCategoryUid],
                    'uid_foreign' => $oldMmRecord['uid_local'],
                    'tablenames' => $oldMmRecord['tablenames'] ?: 'tx_sfbanners_domain_model_banner',
                    'sorting_foreign' => $oldMmRecord['sorting'],
                    'fieldname' => 'category',
                ];
                // check if relation already exists
                $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                    ->getQueryBuilderForTable('sys_category_record_mm');
                $foundRelations = $queryBuilder
                    ->count('uid_local')
                    ->from('sys_category_record_mm')
                    ->where(
                        $queryBuilder->expr()->eq(
                            'uid_local',
                            $queryBuilder->createNamedParameter($newMmRecord['uid_local'], \PDO::PARAM_STR)
                        ),
                        $queryBuilder->expr()->eq(
                            'uid_foreign',
                            $queryBuilder->createNamedParameter($newMmRecord['uid_foreign'], \PDO::PARAM_STR)
                        ),
                        $queryBuilder->expr()->eq(
                            'tablenames',
                            $queryBuilder->createNamedParameter($newMmRecord['tablenames'], \PDO::PARAM_STR)
                        ),
                        $queryBuilder->expr()->eq(
                            'fieldname',
                            $queryBuilder->createNamedParameter($newMmRecord['fieldname'], \PDO::PARAM_STR)
                        )
                    )
                    ->execute()
                    ->fetchColumn(0);
                if ($foundRelations === 0) {
                    $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
                    $databaseConnectionForSysCategory = $connectionPool->getConnectionForTable('sys_category_record_mm');
                    $rowsInserted = $databaseConnectionForSysCategory->insert(
                        'sys_category_record_mm',
                        $newMmRecord
                    );
                    if ($rowsInserted === 1) {
                        $newMmCount++;
                    }
                }
            }
        }
        $message = 'Created ' . $newMmCount . ' new MM relations';
        $status = FlashMessage::INFO;
        $title = '';
        $this->messageArray[] = [$status, $title, $message];
    }

    /**
     * Update categories in flexforms
     *
     * @param string $pluginName
     * @param array $oldNewCategoryUidMapping
     * @param string $flexformField name of the flexform's field to look for
     * @return void
     */
    protected function updateFlexformCategories($pluginName, $oldNewCategoryUidMapping, $flexformField)
    {
        $count = 0;
        $message = '';
        $title = 'Update flexforms categories (' . $pluginName . ':' . $flexformField . ')';

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder
            ->select('uid', 'pi_flexform')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'CType',
                    $queryBuilder->createNamedParameter('list', \PDO::PARAM_STR)
                ),
                $queryBuilder->expr()->eq(
                    'list_type',
                    $queryBuilder->createNamedParameter($pluginName, \PDO::PARAM_STR)
                ),
                $queryBuilder->expr()->eq(
                    'deleted',
                    $queryBuilder->createNamedParameter(0, \PDO::PARAM_INT)
                )
            )
            ->execute();

        /** @var \TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools $flexformTools */
        $flexformTools = GeneralUtility::makeInstance(FlexFormTools::class);
        foreach ($rows as $row) {
            $status = null;
            $xmlArray = GeneralUtility::xml2array($row['pi_flexform']);
            if (!is_array($xmlArray) || !isset($xmlArray['data'])) {
                $status = FlashMessage::ERROR;
                $message = 'Flexform data of plugin "' . $pluginName . '" not found.';
            } elseif (!isset($xmlArray['data']['sDEF']['lDEF'])) {
                $status = FlashMessage::WARNING;
                $message = 'Flexform data of record tt_content:' . $row['uid'] . ' did not contain sheet: sDEF';
            } elseif (isset($xmlArray[$flexformField . '_updated'])) {
                $status = FlashMessage::NOTICE;
                $message = 'Flexform data of record tt_content:' . $row['uid'] . ' is already updated for ' . $flexformField . '. No update needed...';
            } else {
                // Some flexforms may have displayCond
                if (isset($xmlArray['data']['sDEF']['lDEF'][$flexformField]['vDEF'])) {
                    $updated = false;
                    $oldCategories = GeneralUtility::trimExplode(
                        ',',
                        $xmlArray['data']['sDEF']['lDEF'][$flexformField]['vDEF'],
                        true
                    );
                    if (!empty($oldCategories)) {
                        $newCategories = [];
                        foreach ($oldCategories as $uid) {
                            if (isset($oldNewCategoryUidMapping[$uid])) {
                                $newCategories[] = $oldNewCategoryUidMapping[$uid];
                                $updated = true;
                            } else {
                                $status = FlashMessage::WARNING;
                                $message = 'The category ' . $uid . ' of record tt_content:' . $row['uid'] . ' was not found in sys_category records. Maybe the category was deleted before the migration? Please check manually...';
                            }
                        }
                        if ($updated) {
                            $count++;
                            $xmlArray[$flexformField . '_updated'] = 1;
                            $xmlArray['data']['sDEF']['lDEF'][$flexformField]['vDEF'] = implode(',', $newCategories);

                            $connection = GeneralUtility::makeInstance(ConnectionPool::class)
                                ->getConnectionForTable('tt_content');
                            $connection->update(
                                'tt_content',
                                ['pi_flexform' => $flexformTools->flexArray2Xml($xmlArray)],
                                ['uid' => (int)$row['uid']]
                            );
                        }
                    }
                }
            }
            if ($status !== null) {
                $this->messageArray[] = [$status, $title, $message];
            }
        }
        $status = FlashMessage::INFO;
        $message = 'Updated ' . $count . ' tt_content flexforms for  "' . $pluginName . ':' . $flexformField . '"';
        $this->messageArray[] = [$status, $title, $message];
    }

    /**
     * Gets the message severity class name
     *
     * @param int $severity
     * @return string The message severity class name
     */
    public function getClass($severity)
    {
        $classes = [
            FlashMessage::NOTICE => 'notice',
            FlashMessage::INFO => 'info',
            FlashMessage::OK => 'success',
            FlashMessage::WARNING => 'warning',
            FlashMessage::ERROR => 'danger'
        ];

        return 'alert-' . $classes[$severity];
    }

    /**
     * Gets the message severity icon name
     *
     * @param int $severity
     * @return string The message severity icon name
     */
    public function getIconName($severity)
    {
        $icons = [
            FlashMessage::NOTICE => 'lightbulb-o',
            FlashMessage::INFO => 'info',
            FlashMessage::OK => 'check',
            FlashMessage::WARNING => 'exclamation',
            FlashMessage::ERROR => 'times'
        ];

        return $icons[$severity];
    }

    /**
     * Returns the HTML for the given message.
     *
     * @param string $message
     * @param string $title
     * @param int $severity
     * @return string
     */
    protected function getFlashMessage($message, $title, $severity)
    {
        if (!empty($title)) {
            $title = '<h4 class="alert-title">' . $title . '</h4>';
        }
        $message = '
			<div class="alert ' . $this->getClass($severity) . '">
				<div class="media">
					<div class="media-left">
						<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-' . $this->getIconName($severity) . ' fa-stack-1x"></i>
						</span>
					</div>
					<div class="media-body">
						' . $title . '
						<div class="alert-message">' . $message . '</div>
					</div>
				</div>
			</div>';

        return $message;
    }

    /**
     * Check if given table exists
     *
     * @param string $table
     * @return bool
     */
    public function checkIfTableExists($table)
    {
        $tableExists = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable($table)
            ->getSchemaManager()
            ->tablesExist([$table]);

        return $tableExists;
    }
}

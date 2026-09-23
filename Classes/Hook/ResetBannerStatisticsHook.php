<?php

namespace DERHANSEN\SfBanners\Hook;

use TYPO3\CMS\Core\DataHandling\DataHandler;

/**
 * Resets the "impressions" and "clicks" counters for every newly created banner record.
 * This prevents those statistics from being carried over when a banner record is copied.
 */
final class ResetBannerStatisticsHook
{
    private const TABLE = 'tx_sfbanners_domain_model_banner';

    /**
     * @param array $incomingFieldArray
     * @param string $table
     * @param string|int $id UID of the record, or a "NEW..." placeholder for new records
     * @param DataHandler $dataHandler
     */
    public function processDatamap_preProcessFieldArray(
        ?array &$incomingFieldArray,
        string $table,
        string|int $id,
        DataHandler $dataHandler,
    ): void {
        if ($table !== self::TABLE) {
            return;
        }

        // Only apply on new records (copy, paste, localize, ...)
        if (!is_string($id) || !str_starts_with($id, 'NEW')) {
            return;
        }

        $incomingFieldArray['impressions'] = 0;
        $incomingFieldArray['clicks'] = 0;
    }
}

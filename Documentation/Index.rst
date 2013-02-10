..  Editor configuration
	...................................................
	* utf-8 with BOM as encoding
	* tab indentation with 4 characters (no space)
	* no wrapping when reaching the end of the margin, configuration with soft carriage return

.. Includes roles, substitutions, ...
.. include:: _Inclusion.rst

=================
Banner Management
=================

:Extension name: Extension Name
:Extension key: sf_banners
:Version: x.y.z
:Language: en
:Description: manuals covering TYPO3 basics
:Copyright: 2012-2013
:Author: Torben Hansen
:Email: derhansen@gmail.com
:Licence: Open Content License available from `www.opencontent.org/opl.shtml <http://www.opencontent.org/opl.shtml>`_

The content of this document is related to TYPO3,

a GNU/GPL CMS/Framework available from `www.typo3.org
<http://www.typo3.org/>`_


**Table of Contents**

.. toctree::
	:maxdepth: 5
	:titlesonly:
	:glob:

	UserManual
	AdministratorManual
	TyposcriptReference
	DeveloperCorner
	ProjectInformation
	RestructuredtextHelp

.. STILL TO ADD IN THIS DOCUMENT
	@todo: add section about how screenshots can be automated. Pointer to PhantomJS could be added.
	@todo: explain how documentation can be rendered locally and remotely.
	@todo: explain which files should be versioned and which not (_build, Makefile, conf.py, ...)
	@todo: a word about inclusion

What does it do?
=================

First of all, if you have any idea how this template can be improved, please, drop a note to our team_. Documentation is written in reST format. Please, refer to Help writing reStructuredText to get some insight regarding syntax and existing reST editors on the market.

.. _team: http://forge.typo3.org/projects/typo3v4-official_extension_template/issues

Here should be given a brief overview of the extension. What does it do? What problem does it solve? Who is interested in this? Basically the document includes everything people need to know to decide, if they should go on with this extension.

.. figure:: Images/IntroductionPackage.png
		:width: 500px
		:alt: Introduction Package

		Introduction Package just after installation (caption of the image)

		How the Frontend of the Introduction Package looks like just after installation (legend of the image)

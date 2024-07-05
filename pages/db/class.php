<h1>Класс ORM-сущности</h1>

<p>В классе обязательно должны быть два метода:</p>
<ul>
  <li><mark>getTableName()</mark> - указывается название базы данных</li>
  <li><mark>getMap()</mark> - перечисляются все поля таблицы</li>
</ul>

<p>Поля могут задаваться как объекты или как массивы. Вариант с массивами считается устаревшим, но продолжает использоваться. В классе также могут быть заданы валидаторы для полей.</p>

<p>Пример - класс для работы с таблицей инфоблоков <mark>b_iblock</mark>:</p>
<pre>
  <code>

    namespace Bitrix\Iblock;

    use Bitrix\Main\Localization\Loc;
    use Bitrix\Main\ORM\Data\DataManager;
    use Bitrix\Main\ORM\Fields;
    use Bitrix\Main\Type;

    Loc::loadMessages(__FILE__);

    class IblockTable extends DataManager
    {
      public static function getTableName()
      {
        return 'b_iblock';
      }

      public static function getMap()
      {
        return [
          new Fields\IntegerField(
            'ID',
            [
              'primary' => true,
              'autocomplete' => true,
              'title' => Loc::getMessage('IBLOCK_ENTITY_ID_FIELD')
            ]
          ),
          new Fields\DatetimeField(
            'TIMESTAMP_X',
            [
              'default' => function () {
                return new Type\DateTime();
              },
              'title' => Loc::getMessage('IBLOCK_ENTITY_TIMESTAMP_X_FIELD')
            ]
          ),
          new Fields\StringField(
            'IBLOCK_TYPE_ID',
            [
              'required' => true,
              'validation' => [__CLASS__, 'validateIblockTypeId'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_IBLOCK_TYPE_ID_FIELD')
            ]
          ),
          new Fields\StringField(
            'LID',
            [
              'required' => true,
              'validation' => [__CLASS__, 'validateLid'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_LID_FIELD')
            ]
          ),
          new Fields\StringField(
            'CODE',
            [
              'validation' => [__CLASS__, 'validateCode'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_CODE_FIELD')
            ]
          ),
          new Fields\StringField(
            'API_CODE',
            [
              'validation' => [__CLASS__, 'validateApiCode'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_API_CODE_FIELD')
            ]
          ),
          new Fields\BooleanField(
            'REST_ON',
            [
              'values' => array('N', 'Y'),
              'default' => 'N',
              'title' => Loc::getMessage('IBLOCK_ENTITY_REST_ON_FIELD')
            ]
          ),
          new Fields\StringField(
            'NAME',
            [
              'required' => true,
              'validation' => [__CLASS__, 'validateName'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_NAME_FIELD')
            ]
          ),
          new Fields\BooleanField(
            'ACTIVE',
            [
              'values' => array('N', 'Y'),
              'default' => 'Y',
              'title' => Loc::getMessage('IBLOCK_ENTITY_ACTIVE_FIELD')
            ]
          ),
          new Fields\IntegerField(
            'SORT',
            [
              'default' => 500,
              'title' => Loc::getMessage('IBLOCK_ENTITY_SORT_FIELD')
            ]
          ),
          new Fields\StringField(
            'LIST_PAGE_URL',
            [
              'validation' => [__CLASS__, 'validateListPageUrl'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_LIST_PAGE_URL_FIELD')
            ]
          ),
          new Fields\StringField(
            'DETAIL_PAGE_URL',
            [
              'validation' => [__CLASS__, 'validateDetailPageUrl'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_DETAIL_PAGE_URL_FIELD')
            ]
          ),
          new Fields\StringField(
            'SECTION_PAGE_URL',
            [
              'validation' => [__CLASS__, 'validateSectionPageUrl'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_SECTION_PAGE_URL_FIELD')
            ]
          ),
          new Fields\StringField(
            'CANONICAL_PAGE_URL',
            [
              'validation' => [__CLASS__, 'validateCanonicalPageUrl'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_CANONICAL_PAGE_URL_FIELD')
            ]
          ),
          new Fields\IntegerField(
            'PICTURE',
            [
              'title' => Loc::getMessage('IBLOCK_ENTITY_PICTURE_FIELD')
            ]
          ),
          new Fields\TextField(
            'DESCRIPTION',
            [
              'title' => Loc::getMessage('IBLOCK_ENTITY_DESCRIPTION_FIELD')
            ]
          ),
          new Fields\StringField(
            'DESCRIPTION_TYPE',
            [
              'values' => array('text', 'html'),
              'default' => 'text',
              'title' => Loc::getMessage('IBLOCK_ENTITY_DESCRIPTION_TYPE_FIELD')
            ]
          ),
          new Fields\IntegerField(
            'RSS_TTL',
            [
              'default' => 24,
              'title' => Loc::getMessage('IBLOCK_ENTITY_RSS_TTL_FIELD')
            ]
          ),
          new Fields\BooleanField(
            'RSS_ACTIVE',
            [
              'values' => array('N', 'Y'),
              'default' => 'Y',
              'title' => Loc::getMessage('IBLOCK_ENTITY_RSS_ACTIVE_FIELD')
            ]
          ),
          new Fields\BooleanField(
            'RSS_FILE_ACTIVE',
            [
              'values' => array('N', 'Y'),
              'default' => 'N',
              'title' => Loc::getMessage('IBLOCK_ENTITY_RSS_FILE_ACTIVE_FIELD')
            ]
          ),
          new Fields\IntegerField(
            'RSS_FILE_LIMIT',
            [
              'title' => Loc::getMessage('IBLOCK_ENTITY_RSS_FILE_LIMIT_FIELD')
            ]
          ),
          new Fields\IntegerField(
            'RSS_FILE_DAYS',
            [
              'title' => Loc::getMessage('IBLOCK_ENTITY_RSS_FILE_DAYS_FIELD')
            ]
          ),
          new Fields\BooleanField(
            'RSS_YANDEX_ACTIVE',
            [
              'values' => array('N', 'Y'),
              'default' => 'N',
              'title' => Loc::getMessage('IBLOCK_ENTITY_RSS_YANDEX_ACTIVE_FIELD')
            ]
          ),
          new Fields\StringField(
            'XML_ID',
            [
              'validation' => [__CLASS__, 'validateXmlId'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_XML_ID_FIELD')
            ]
          ),
          new Fields\StringField(
            'TMP_ID',
            [
              'validation' => [__CLASS__, 'validateTmpId'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_TMP_ID_FIELD')
            ]
          ),
          new Fields\BooleanField(
            'INDEX_ELEMENT',
            [
              'values' => array('N', 'Y'),
              'default' => 'Y',
              'title' => Loc::getMessage('IBLOCK_ENTITY_INDEX_ELEMENT_FIELD')
            ]
          ),
          new Fields\BooleanField(
            'INDEX_SECTION',
            [
              'values' => array('N', 'Y'),
              'default' => 'N',
              'title' => Loc::getMessage('IBLOCK_ENTITY_INDEX_SECTION_FIELD')
            ]
          ),
          new Fields\BooleanField(
            'WORKFLOW',
            [
              'values' => array('N', 'Y'),
              'default' => 'Y',
              'title' => Loc::getMessage('IBLOCK_ENTITY_WORKFLOW_FIELD')
            ]
          ),
          new Fields\BooleanField(
            'BIZPROC',
            [
              'values' => array('N', 'Y'),
              'default' => 'N',
              'title' => Loc::getMessage('IBLOCK_ENTITY_BIZPROC_FIELD')
            ]
          ),
          new Fields\StringField(
            'SECTION_CHOOSER',
            [
              'validation' => [__CLASS__, 'validateSectionChooser'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_SECTION_CHOOSER_FIELD')
            ]
          ),
          new Fields\StringField(
            'LIST_MODE',
            [
              'validation' => [__CLASS__, 'validateListMode'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_LIST_MODE_FIELD')
            ]
          ),
          new Fields\StringField(
            'RIGHTS_MODE',
            [
              'validation' => [__CLASS__, 'validateRightsMode'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_RIGHTS_MODE_FIELD')
            ]
          ),
          new Fields\StringField(
            'SECTION_PROPERTY',
            [
              'validation' => [__CLASS__, 'validateSectionProperty'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_SECTION_PROPERTY_FIELD')
            ]
          ),
          new Fields\StringField(
            'PROPERTY_INDEX',
            [
              'validation' => [__CLASS__, 'validatePropertyIndex'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_PROPERTY_INDEX_FIELD')
            ]
          ),
          new Fields\IntegerField(
            'VERSION',
            [
              'default' => 1,
              'title' => Loc::getMessage('IBLOCK_ENTITY_VERSION_FIELD')
            ]
          ),
          new Fields\IntegerField(
            'LAST_CONV_ELEMENT',
            [
              'default' => 0,
              'title' => Loc::getMessage('IBLOCK_ENTITY_LAST_CONV_ELEMENT_FIELD')
            ]
          ),
          new Fields\IntegerField(
            'SOCNET_GROUP_ID',
            [
              'title' => Loc::getMessage('IBLOCK_ENTITY_SOCNET_GROUP_ID_FIELD')
            ]
          ),
          new Fields\StringField(
            'EDIT_FILE_BEFORE',
            [
              'validation' => [__CLASS__, 'validateEditFileBefore'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_EDIT_FILE_BEFORE_FIELD')
            ]
          ),
          new Fields\StringField(
            'EDIT_FILE_AFTER',
            [
              'validation' => [__CLASS__, 'validateEditFileAfter'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_EDIT_FILE_AFTER_FIELD')
            ]
          ),
          new Fields\StringField(
            'SECTIONS_NAME',
            [
              'validation' => [__CLASS__, 'validateSectionsName'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_SECTIONS_NAME_FIELD')
            ]
          ),
          new Fields\StringField(
            'SECTION_NAME',
            [
              'validation' => [__CLASS__, 'validateSectionName'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_SECTION_NAME_FIELD')
            ]
          ),
          new Fields\StringField(
            'ELEMENTS_NAME',
            [
              'validation' => [__CLASS__, 'validateElementsName'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_ELEMENTS_NAME_FIELD')
            ]
          ),
          new Fields\StringField(
            'ELEMENT_NAME',
            [
              'validation' => [__CLASS__, 'validateElementName'],
              'title' => Loc::getMessage('IBLOCK_ENTITY_ELEMENT_NAME_FIELD')
            ]
          ),
          new Fields\Relations\Reference(
            'FILE',
            '\Bitrix\File\File',
            ['=this.PICTURE' => 'ref.ID'],
            ['join_type' => 'LEFT']
          ),
          new Fields\Relations\Reference(
            'IBLOCK_TYPE',
            '\Bitrix\Iblock\IblockType',
            ['=this.IBLOCK_TYPE_ID' => 'ref.ID'],
            ['join_type' => 'LEFT']
          ),
          new Fields\Relations\Reference(
            'LANG',
            '\Bitrix\Lang\Lang',
            ['=this.LID' => 'ref.LID'],
            ['join_type' => 'LEFT']
          ),
          new Fields\Relations\Reference(
            'SOCNET_GROUP',
            '\Bitrix\Sonet\SonetGroup',
            ['=this.SOCNET_GROUP_ID' => 'ref.ID'],
            ['join_type' => 'LEFT']
          ),
        ];
      }

      public static function validateIblockTypeId()
      {
        return [
          new Fields\Validators\LengthValidator(null, 50),
        ];
      }

      public static function validateLid()
      {
        return [
          new Fields\Validators\LengthValidator(null, 2),
        ];
      }

      public static function validateCode()
      {
        return [
          new Fields\Validators\LengthValidator(null, 50),
        ];
      }

      public static function validateApiCode()
      {
        return [
          new Fields\Validators\LengthValidator(null, 50),
        ];
      }

      public static function validateName()
      {
        return [
          new Fields\Validators\LengthValidator(null, 255),
        ];
      }

      public static function validateListPageUrl()
      {
        return [
          new Fields\Validators\LengthValidator(null, 255),
        ];
      }

      public static function validateDetailPageUrl()
      {
        return [
          new Fields\Validators\LengthValidator(null, 255),
        ];
      }

      public static function validateSectionPageUrl()
      {
        return [
          new Fields\Validators\LengthValidator(null, 255),
        ];
      }

      public static function validateCanonicalPageUrl()
      {
        return [
          new Fields\Validators\LengthValidator(null, 255),
        ];
      }

      public static function validateXmlId()
      {
        return [
          new Fields\Validators\LengthValidator(null, 255),
        ];
      }

      public static function validateTmpId()
      {
        return [
          new Fields\Validators\LengthValidator(null, 40),
        ];
      }

      public static function validateSectionChooser()
      {
        return [
          new Fields\Validators\LengthValidator(null, 1),
        ];
      }
      public static function validateListMode()
      {
        return [
          new Fields\Validators\LengthValidator(null, 1),
        ];
      }
      public static function validateRightsMode()
      {
        return [
          new Fields\Validators\LengthValidator(null, 1),
        ];
      }
      public static function validateSectionProperty()
      {
        return [
          new Fields\Validators\LengthValidator(null, 1),
        ];
      }

      public static function validatePropertyIndex()
      {
        return [
          new Fields\Validators\LengthValidator(null, 1),
        ];
      }

      public static function validateEditFileBefore()
      {
        return [
          new Fields\Validators\LengthValidator(null, 255),
        ];
      }

      public static function validateEditFileAfter()
      {
        return [
          new Fields\Validators\LengthValidator(null, 255),
        ];
      }

      public static function validateSectionsName()
      {
        return [
          new Fields\Validators\LengthValidator(null, 100),
        ];
      }

      public static function validateSectionName()
      {
        return [
          new Fields\Validators\LengthValidator(null, 100),
        ];
      }

      public static function validateElementsName()
      {
        return [
          new Fields\Validators\LengthValidator(null, 100),
        ];
      }

      public static function validateElementName()
      {
        return [
          new Fields\Validators\LengthValidator(null, 100),
        ];
      }
    }
  </code>
</pre>

<p>Еще один пример - класс для работы с таблицей элементов инфоблоков <mark>b_iblock_element</mark> (использован синтаксис с массивами):</p>
<pre>
  <code>
    namespace Bitrix\Iblock;

    use Bitrix\Main;
    use Bitrix\Main\Entity\DataManager;
    use Bitrix\Main\Localization\Loc;

    Loc::loadMessages(__FILE__);

    class ElementTable extends DataManager
    {
      public static function getTableName()
      {
        return 'b_iblock_element';
      }

      public static function getMap()
      {
        return [
          'ID' => [
            'data_type' => 'integer',
            'primary' => true,
            'autocomplete' => true,
            'title' => Loc::getMessage('ELEMENT_ENTITY_ID_FIELD'),
          ],
          'TIMESTAMP_X' => [
            'data_type' => 'datetime',
            'title' => Loc::getMessage('ELEMENT_ENTITY_TIMESTAMP_X_FIELD'),
          ],
          'MODIFIED_BY' => [
            'data_type' => 'integer',
            'title' => Loc::getMessage('ELEMENT_ENTITY_MODIFIED_BY_FIELD'),
          ],
          'DATE_CREATE' => [
            'data_type' => 'datetime',
            'title' => Loc::getMessage('ELEMENT_ENTITY_DATE_CREATE_FIELD'),
          ],
          'CREATED_BY' => [
            'data_type' => 'integer',
            'title' => Loc::getMessage('ELEMENT_ENTITY_CREATED_BY_FIELD'),
          ],
          'IBLOCK_ID' => [
            'data_type' => 'integer',
            'required' => true,
            'title' => Loc::getMessage('ELEMENT_ENTITY_IBLOCK_ID_FIELD'),
          ],
          'IBLOCK_SECTION_ID' => [
            'data_type' => 'integer',
            'title' => Loc::getMessage('ELEMENT_ENTITY_IBLOCK_SECTION_ID_FIELD'),
          ],
          'ACTIVE' => [
            'data_type' => 'boolean',
            'values' => ['N', 'Y'],
            'title' => Loc::getMessage('ELEMENT_ENTITY_ACTIVE_FIELD'),
          ],
          'ACTIVE_FROM' => [
            'data_type' => 'datetime',
            'title' => Loc::getMessage('ELEMENT_ENTITY_ACTIVE_FROM_FIELD'),
          ],
          'ACTIVE_TO' => [
            'data_type' => 'datetime',
            'title' => Loc::getMessage('ELEMENT_ENTITY_ACTIVE_TO_FIELD'),
          ],
          'SORT' => [
            'data_type' => 'integer',
            'title' => Loc::getMessage('ELEMENT_ENTITY_SORT_FIELD'),
          ],
          'NAME' => [
            'data_type' => 'string',
            'required' => true,
            'validation' => [__CLASS__, 'validateName'],
            'title' => Loc::getMessage('ELEMENT_ENTITY_NAME_FIELD'),
          ],
          'PREVIEW_PICTURE' => [
            'data_type' => 'integer',
            'title' => Loc::getMessage('ELEMENT_ENTITY_PREVIEW_PICTURE_FIELD'),
          ],
          'PREVIEW_TEXT' => [
            'data_type' => 'text',
            'title' => Loc::getMessage('ELEMENT_ENTITY_PREVIEW_TEXT_FIELD'),
          ],
          'PREVIEW_TEXT_TYPE' => [
            'data_type' => 'enum',
            'values' => ['text', 'html'],
            'title' => Loc::getMessage('ELEMENT_ENTITY_PREVIEW_TEXT_TYPE_FIELD'),
          ],
          'DETAIL_PICTURE' => [
            'data_type' => 'integer',
            'title' => Loc::getMessage('ELEMENT_ENTITY_DETAIL_PICTURE_FIELD'),
          ],
          'DETAIL_TEXT' => [
            'data_type' => 'text',
            'title' => Loc::getMessage('ELEMENT_ENTITY_DETAIL_TEXT_FIELD'),
          ],
          'DETAIL_TEXT_TYPE' => [
            'data_type' => 'enum',
            'values' => ['text', 'html'],
            'title' => Loc::getMessage('ELEMENT_ENTITY_DETAIL_TEXT_TYPE_FIELD'),
          ],
          'SEARCHABLE_CONTENT' => [
            'data_type' => 'text',
            'title' => Loc::getMessage('ELEMENT_ENTITY_SEARCHABLE_CONTENT_FIELD'),
          ],
          'WF_STATUS_ID' => [
            'data_type' => 'integer',
            'title' => Loc::getMessage('ELEMENT_ENTITY_WF_STATUS_ID_FIELD'),
          ],
          'WF_PARENT_ELEMENT_ID' => [
            'data_type' => 'integer',
            'title' => Loc::getMessage('ELEMENT_ENTITY_WF_PARENT_ELEMENT_ID_FIELD'),
          ],
          'WF_NEW' => [
            'data_type' => 'string',
            'validation' => [__CLASS__, 'validateWfNew'],
            'title' => Loc::getMessage('ELEMENT_ENTITY_WF_NEW_FIELD'),
          ],
          'WF_LOCKED_BY' => [
            'data_type' => 'integer',
            'title' => Loc::getMessage('ELEMENT_ENTITY_WF_LOCKED_BY_FIELD'),
          ],
          'WF_DATE_LOCK' => [
            'data_type' => 'datetime',
            'title' => Loc::getMessage('ELEMENT_ENTITY_WF_DATE_LOCK_FIELD'),
          ],
          'WF_COMMENTS' => [
            'data_type' => 'text',
            'title' => Loc::getMessage('ELEMENT_ENTITY_WF_COMMENTS_FIELD'),
          ],
          'IN_SECTIONS' => [
            'data_type' => 'boolean',
            'values' => ['N', 'Y'],
            'title' => Loc::getMessage('ELEMENT_ENTITY_IN_SECTIONS_FIELD'),
          ],
          'XML_ID' => [
            'data_type' => 'string',
            'validation' => [__CLASS__, 'validateXmlId'],
            'title' => Loc::getMessage('ELEMENT_ENTITY_XML_ID_FIELD'),
          ],
          'CODE' => [
            'data_type' => 'string',
            'validation' => [__CLASS__, 'validateCode'],
            'title' => Loc::getMessage('ELEMENT_ENTITY_CODE_FIELD'),
          ],
          'TAGS' => [
            'data_type' => 'string',
            'validation' => [__CLASS__, 'validateTags'],
            'title' => Loc::getMessage('ELEMENT_ENTITY_TAGS_FIELD'),
          ],
          'TMP_ID' => [
            'data_type' => 'string',
            'validation' => [__CLASS__, 'validateTmpId'],
            'title' => Loc::getMessage('ELEMENT_ENTITY_TMP_ID_FIELD'),
          ],
          'WF_LAST_HISTORY_ID' => [
            'data_type' => 'integer',
            'title' => Loc::getMessage('ELEMENT_ENTITY_WF_LAST_HISTORY_ID_FIELD'),
          ],
          'SHOW_COUNTER' => [
            'data_type' => 'integer',
            'title' => Loc::getMessage('ELEMENT_ENTITY_SHOW_COUNTER_FIELD'),
          ],
          'SHOW_COUNTER_START' => [
            'data_type' => 'datetime',
            'title' => Loc::getMessage('ELEMENT_ENTITY_SHOW_COUNTER_START_FIELD'),
          ],
          'PREVIEW_PICTURE' => [
            'data_type' => 'Bitrix\File\File',
            'reference' => ['=this.PREVIEW_PICTURE' => 'ref.ID'],
          ],
          'DETAIL_PICTURE' => [
            'data_type' => 'Bitrix\File\File',
            'reference' => ['=this.DETAIL_PICTURE' => 'ref.ID'],
          ],
          'IBLOCK' => [
            'data_type' => 'Bitrix\Iblock\Iblock',
            'reference' => ['=this.IBLOCK_ID' => 'ref.ID'],
          ],
          'WF_PARENT_ELEMENT' => [
            'data_type' => 'Bitrix\Iblock\IblockElement',
            'reference' => ['=this.WF_PARENT_ELEMENT_ID' => 'ref.ID'],
          ],
          'IBLOCK_SECTION' => [
            'data_type' => 'Bitrix\Iblock\IblockSection',
            'reference' => ['=this.IBLOCK_SECTION_ID' => 'ref.ID'],
          ],
          'MODIFIED_BY' => [
            'data_type' => 'Bitrix\User\User',
            'reference' => ['=this.MODIFIED_BY' => 'ref.ID'],
          ],
          'CREATED_BY' => [
            'data_type' => 'Bitrix\User\User',
            'reference' => ['=this.CREATED_BY' => 'ref.ID'],
          ],
          'WF_LOCKED_BY' => [
            'data_type' => 'Bitrix\User\User',
            'reference' => ['=this.WF_LOCKED_BY' => 'ref.ID'],
          ],
        ];
      }

      public static function validateName()
      {
        return [
          new Main\Entity\Validator\Length(null, 255),
        ];
      }

      public static function validateWfNew()
      {
        return [
          new Main\Entity\Validator\Length(null, 1),
        ];
      }

      public static function validateXmlId()
      {
        return [
          new Main\Entity\Validator\Length(null, 255),
        ];
      }

      public static function validateCode()
      {
        return [
          new Main\Entity\Validator\Length(null, 255),
        ];
      }

      public static function validateTags()
      {
        return [
          new Main\Entity\Validator\Length(null, 255),
        ];
      }

      public static function validateTmpId()
      {
        return [
          new Main\Entity\Validator\Length(null, 40),
        ];
      }
    }
  </code>
</pre>
<p>Класс описывает таблицу БД <mark>b_iblock_element</mark>, которая хранит элементы инфоблоков:</p>
<pre>
  <code class="language-sql">
    CREATE TABLE `b_iblock_element` (
      `ID` int(11) NOT NULL,
      `TIMESTAMP_X` datetime DEFAULT NULL,
      `MODIFIED_BY` int(18) DEFAULT NULL,
      `DATE_CREATE` datetime DEFAULT NULL,
      `CREATED_BY` int(18) DEFAULT NULL,
      `IBLOCK_ID` int(11) NOT NULL DEFAULT '0',
      `IBLOCK_SECTION_ID` int(11) DEFAULT NULL,
      `ACTIVE` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y',
      `ACTIVE_FROM` datetime DEFAULT NULL,
      `ACTIVE_TO` datetime DEFAULT NULL,
      `SORT` int(11) NOT NULL DEFAULT '500',
      `NAME` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `PREVIEW_PICTURE` int(18) DEFAULT NULL,
      `PREVIEW_TEXT` text COLLATE utf8_unicode_ci,
      `PREVIEW_TEXT_TYPE` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
      `DETAIL_PICTURE` int(18) DEFAULT NULL,
      `DETAIL_TEXT` longtext COLLATE utf8_unicode_ci,
      `DETAIL_TEXT_TYPE` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
      `SEARCHABLE_CONTENT` text COLLATE utf8_unicode_ci,
      `WF_STATUS_ID` int(18) DEFAULT '1',
      `WF_PARENT_ELEMENT_ID` int(11) DEFAULT NULL,
      `WF_NEW` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
      `WF_LOCKED_BY` int(18) DEFAULT NULL,
      `WF_DATE_LOCK` datetime DEFAULT NULL,
      `WF_COMMENTS` text COLLATE utf8_unicode_ci,
      `IN_SECTIONS` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
      `XML_ID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
      `CODE` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
      `TAGS` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
      `TMP_ID` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
      `WF_LAST_HISTORY_ID` int(11) DEFAULT NULL,
      `SHOW_COUNTER` int(18) DEFAULT NULL,
      `SHOW_COUNTER_START` datetime DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
      
    ALTER TABLE `b_iblock_element`
    ADD PRIMARY KEY (`ID`),
    ADD KEY `ix_iblock_element_1` (`IBLOCK_ID`,`IBLOCK_SECTION_ID`),
    ADD KEY `ix_iblock_element_4` (`IBLOCK_ID`,`XML_ID`,`WF_PARENT_ELEMENT_ID`),
    ADD KEY `ix_iblock_element_3` (`WF_PARENT_ELEMENT_ID`),
    ADD KEY `ix_iblock_element_code` (`IBLOCK_ID`,`CODE`);

    ALTER TABLE `b_iblock_element`
    MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
  </code>
</pre>

<p>В <mark>getMap</mark> перечислены все поля таблицы, включая описание связей с другими сущностями. В примере таким образом указано отношение столбца <mark>IBLOCK_ID</mark> текущей таблицы и столбца <mark>ID</mark> сущности <mark>Iblock</mark>. В дальнейшем по <mark>reference</mark> полям возможно выбирать поля связанных сущностей и использовать их в фильтрах.</p>
<pre>
  <code class="language-php">
    'IBLOCK' => [
      'data_type' => 'Bitrix\Iblock\Iblock',
      'reference' => ['=this.IBLOCK_ID' => 'ref.ID'],
    ]
  </code>
</pre>
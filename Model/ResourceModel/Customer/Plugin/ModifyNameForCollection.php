<?php
namespace Veriteworks\Localize\Model\ResourceModel\Customer\Plugin;
use Magento\Customer\Model\ResourceModel\Customer\Colection;
use Magento\Customer\Model\ResourceModel\Customer\Collection;

class ModifyNameForCollection
{
    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    protected $_localeResolver;

    /**
     * @var \Magento\Framework\DataObject\Copy\Config
     */
    protected $_fieldsetConfig;


    /**
     * @param ResolverInterface $localeResolver
     * @param \Magento\Framework\DataObject\Copy\Config $fieldsetConfig
     */
    public function __construct(
        \Magento\Framework\Locale\ResolverInterface $localeResolver,
        \Magento\Framework\DataObject\Copy\Config $fieldsetConfig
    ) {
        $this->_localeResolver = $localeResolver;
        $this->_fieldsetConfig = $fieldsetConfig;
    }

    public function aroundAddNameToSelect(Collection $subject,
                                          \Closure $proceed
    )
    {
        $fields = [];
        $customerAccount = $this->_fieldsetConfig->getFieldset('customer_account');
        foreach ($customerAccount as $code => $field) {
            if (isset($field['name'])) {
                $fields[$code] = $code;
            }
        }

        $connection = $subject->getConnection();
        $concatenate = [];
        if (isset($fields['prefix'])) {
            $concatenate[] = $connection->getCheckSql(
                '{{prefix}} IS NOT NULL AND {{prefix}} != \'\'',
                $connection->getConcatSql(['LTRIM(RTRIM({{prefix}}))', '\' \'']),
                '\'\''
            );
        }
        if($this->_localeResolver->getLocale() != 'ja_JP') {
            $concatenate[] = 'LTRIM(RTRIM({{firstname}}))';
        } else {
            $concatenate[] = 'LTRIM(RTRIM({{lastname}}))';
        }

        $concatenate[] = '\' \'';
        if (isset($fields['middlename'])) {
            $concatenate[] = $connection->getCheckSql(
                '{{middlename}} IS NOT NULL AND {{middlename}} != \'\'',
                $connection->getConcatSql(['LTRIM(RTRIM({{middlename}}))', '\' \'']),
                '\'\''
            );
        }
        if($this->_localeResolver->getLocale() != 'ja_JP') {
            $concatenate[] = 'LTRIM(RTRIM({{lastname}}))';
        } else {
            $concatenate[] = 'LTRIM(RTRIM({{firstname}}))';
        }
        if (isset($fields['suffix'])) {
            $concatenate[] = $connection->getCheckSql(
                '{{suffix}} IS NOT NULL AND {{suffix}} != \'\'',
                $connection->getConcatSql(['\' \'', 'LTRIM(RTRIM({{suffix}}))']),
                '\'\''
            );
        }

        $nameExpr = $connection->getConcatSql($concatenate);

        $subject->addExpressionAttributeToSelect('name', $nameExpr, $fields);

        return $subject;
    }
}
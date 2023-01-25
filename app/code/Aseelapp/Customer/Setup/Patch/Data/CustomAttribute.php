<?php

namespace Aseelapp\Customer\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Config;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

class CustomAttribute implements DataPatchInterface
{

    /** @var ModuleDataSetupInterface  */
    private $moduleSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var Config
     */
    private $eavConfig;
    public function __construct(ModuleDataSetupInterface $moduleDataSetup, CustomerSetupFactory $customerSetupFactory, Config $eavConfig)
    {
        $this->moduleSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->eavConfig = $eavConfig;
    }
    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }

    /**
     * @throws \Zend_Validate_Exception
     * @throws LocalizedException
     */
    public function apply()
    {
        $eavSetup = $this->customerSetupFactory->create(['setup' => $this->moduleSetup]);
        $customerEntity = $eavSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $eavSetup->getDefaultAttributeSetId($customerEntity->getEntityTypeId());
        $attributeGroup = $eavSetup->getDefaultAttributeGroupId($customerEntity->getEntityTypeId(), $attributeSetId);
        $eavSetup->addAttribute(
            Customer::ENTITY,
            'custom_gender',
            [
                'type' => 'text',
                'label' => 'Customer Gender',
                'input' => 'select',
                'source' => \Aseelapp\Customer\Model\Source\GenderOptions::class,
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'position' => 300
            ]
        );

        $customGenderAttribute = $this->eavConfig->getAttribute(
            Customer::ENTITY,
            'custom_gender'
        );
        $customerForms = ['adminhtml_customer'];

        $customGenderAttribute->addData(
            [
            'used_in_forms' => $customerForms,
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroup
            ]
        );
    }
g
}

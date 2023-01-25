<?php

namespace Aseelapp\Customer\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class GenderOptions extends AbstractSource
{
    public function getAllOptions(): array
    {
        return  [
            ['label'=>'Male','value'=>'male'],
            ['label'=>'Female','value'=>'female'],
            ['label'=>'Custom','value'=>'custom']
        ];
    }
}

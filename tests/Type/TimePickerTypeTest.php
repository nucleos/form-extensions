<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Form\Tests\Type;

use Nucleos\Form\Type\TimePickerType;

final class TimePickerTypeTest extends BaseTypeTest
{
    public function testSubmitNull($expected = null, $norm = null, $view = ''): void
    {
        parent::testSubmitNull($expected, $norm, $view);
    }

    public function testSubmitNullUsesDefaultEmptyData($emptyData = '05:23', $expectedData = null): void
    {
        $builder = $this->factory->createBuilder($this->getTestedType(), null, [
        ]);

        if ($builder->getCompound()) {
            $emptyData = [];
            foreach ($builder as $field) {
                // empty children should map null (model data) in the compound view data
                $emptyData[$field->getName()] = null;
            }
        } else {
            // simple fields share the view and the model format, unless they use a transformer
            $expectedData = $emptyData;
        }

        $form = $builder->setEmptyData($emptyData)->getForm()->submit(null);

        static::assertSame($emptyData, $form->getViewData());
        static::assertSame('05:23:00', $form->getNormData()->format('H:i:s'));
        static::assertSame('05:23:00', $form->getData()->format('H:i:s'));
    }

    protected function getTestedType(): string
    {
        return TimePickerType::class;
    }
}

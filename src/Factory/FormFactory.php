<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface as SymfonyFormFactory;
use Symfony\Component\Form\FormInterface;

final class FormFactory implements FormFactoryInterface
{
    /**
     * @var SymfonyFormFactory
     */
    private $formFactory;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array|null
     */
    private $validationGroups;

    /**
     * @param array $validationGroups
     */
    public function __construct(SymfonyFormFactory $formFactory, string $name, string $type, array $validationGroups = null)
    {
        $this->formFactory      = $formFactory;
        $this->name             = $name;
        $this->type             = $type;
        $this->validationGroups = $validationGroups;
    }

    public function create($data = null, array $options = []): FormInterface
    {
        $options = array_merge($this->getDefaultOptions(), $options);

        return $this->formFactory->createNamed($this->name, $this->type, $data, $options);
    }

    /**
     * Gets the list of default form options.
     *
     * @return array<string, mixed>
     */
    private function getDefaultOptions(): array
    {
        return [
            'method'            => 'POST',
            'validation_groups' => $this->validationGroups,
        ];
    }
}

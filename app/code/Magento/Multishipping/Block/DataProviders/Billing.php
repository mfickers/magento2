<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Multishipping\Block\DataProviders;

use Magento\Checkout\ViewModel\CheckoutConfig;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Customer\Model\Address\Config as AddressConfig;
use Magento\Quote\Model\Quote\Address;

/**
 * Provides additional data for multishipping checkout billing step
 *
 * @see \Magento\Multishipping\view\frontend\templates\checkout\billing.phtml
 */
class Billing implements ArgumentInterface
{
    /**
     * @var AddressConfig
     */
    private $addressConfig;

    /**
     * @var CheckoutConfig
     */
    private $checkoutConfig;

    /**
     * @param AddressConfig           $addressConfig
     * @param CheckoutConfig          $checkoutConfig
     */
    public function __construct(
        AddressConfig $addressConfig,
        CheckoutConfig $checkoutConfig
    ) {
        $this->addressConfig = $addressConfig;
        $this->checkoutConfig = $checkoutConfig;
    }

    /**
     * Get address formatted as html string.
     *
     * @param Address $address
     * @return string
     */
    public function getAddressHtml(Address $address): string
    {
        $renderer = $this->addressConfig->getFormatByCode('html')->getRenderer();

        return $renderer->renderArray($address->getData());
    }

    /**
     * Returns serialized checkout config.
     *
     * @return string|false
     * @deprecated
     */
    public function getSerializedCheckoutConfigs(): string
    {
        return $this->checkoutConfig->getSerializedCheckoutConfig();
    }
}

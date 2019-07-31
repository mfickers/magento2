<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Checkout\Block\Cart;

/**
 * @api
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Shipping extends \Magento\Checkout\Block\Cart\AbstractCart
{
    /**
     * @var \Magento\Checkout\Model\CompositeConfigProvider
     */
    protected $configProvider;

    /**
     * @var \Magento\Checkout\ViewModel\CheckoutConfig
     */
    private $checkoutConfig;

    /**
     * @var array|\Magento\Checkout\Block\Checkout\LayoutProcessorInterface[]
     */
    protected $layoutProcessors;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session                  $customerSession
     * @param \Magento\Checkout\Model\Session                  $checkoutSession
     * @param \Magento\Checkout\Model\CompositeConfigProvider  $configProvider
     * @param \Magento\Checkout\ViewModel\CheckoutConfig       $checkoutConfig
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Checkout\Model\CompositeConfigProvider $configProvider,
        \Magento\Checkout\ViewModel\CheckoutConfig $checkoutConfig,
        array $layoutProcessors = [],
        array $data = []
    ) {
        $this->configProvider = $configProvider;
        $this->checkoutConfig = $checkoutConfig;
        $this->layoutProcessors = $layoutProcessors;
        parent::__construct($context, $customerSession, $checkoutSession, $data);
        $this->_isScopePrivate = true;
    }

    /**
     * Retrieve checkout configuration
     *
     * @return array
     * @codeCoverageIgnore
     * @deprecated
     */
    public function getCheckoutConfig()
    {
        return $this->checkoutConfig->getCheckoutConfig();
    }

    /**
     * Retrieve serialized JS layout configuration ready to use in template
     *
     * @return string
     */
    public function getJsLayout()
    {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }

        return json_encode($this->jsLayout, JSON_HEX_TAG);
    }

    /**
     * Get base url for block.
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    /**
     * Retrieve serialized checkout config.
     *
     * @return bool|string
     * @since 100.2.0
     * @deprecated
     */
    public function getSerializedCheckoutConfig()
    {
        $this->checkoutConfig->getSerializedCheckoutConfig();
    }
}

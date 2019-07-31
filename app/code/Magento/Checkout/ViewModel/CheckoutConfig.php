<?php
namespace Magento\Checkout\ViewModel;

use Magento\Checkout\Model\CompositeConfigProvider;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Psr\Log\LoggerInterface;

class CheckoutConfig implements ArgumentInterface
{
    /**
     * @var CompositeConfigProvider
     */
    private $configProvider;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * CheckoutConfig constructor.
     *
     * @param CompositeConfigProvider $configProvider
     * @param SerializerInterface     $serializer
     * @param LoggerInterface         $logger
     */
    public function __construct(
        CompositeConfigProvider $configProvider,
        SerializerInterface $serializer,
        LoggerInterface $logger
    ) {
        $this->configProvider = $configProvider;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * Retrieve checkout configuration
     *
     * @return array
     */
    public function getCheckoutConfig() : array
    {
        return $this->configProvider->getConfig();
    }

    /**
     * Retrieve serialized checkout configuration
     *
     * @return string|false
     */
    public function getSerializedCheckoutConfig()
    {
        try {
            $result = $this->serializer->serialize($this->getCheckoutConfig());
        } catch (\InvalidArgumentException $e) {
            $this->logger->critical('Failed to JSON encode checkout configuration data. ' . json_last_error_msg());
        }

        return $result ?? false;
    }
}

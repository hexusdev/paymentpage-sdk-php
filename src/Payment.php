<?php

namespace ecommpay;

/**
 * Class Payment
 *
 * @link https://developers.ecommpay.com/en/en_PP_Parameters.html
 *
 */
class Payment
{
    /**
     * Payment from customer account
     */
    const PURCHASE_TYPE = 'purchase';

    /**
     * Payment to customer account
     */
    const PAYOUT_TYPE = 'payout';

    /**
     * Recurring payment
     */
    const RECURRING_TYPE = 'recurring';

    const INTERFACE_TYPE = 23;

    /**
     * @var array Payment parameters
     */
    private $params;

    public function __construct(string $projectId, string $paymentId)
    {
        $this->params = [
            'project_id' => $projectId,
            'payment_id' => $paymentId,
            'interface_type' => json_encode(['id' => self::INTERFACE_TYPE]),
        ];
    }

    /**
     * Get payment parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Date and time when the payment period expires.
     *
     * @param \DateTime $time
     *
     * @return Payment
     */
    public function setBestBefore(\DateTime $time)
    {
        $this->params['best_before'] = $time->format('r');
        return $this;
    }

    /**
     * Setter for payment's params, cuts prefix 'set'
     * and convert Pascal case to Snake case,
     * for example: 'setAccountToken'
     * will be converted to 'account_token'.
     * If prefix not found, then throws exception.
     *
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'set') === 0) {
            $key = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', lcfirst(substr($name, 3))));
            $this->params[$key] = $arguments[0];

            return $this;
        }

        throw new \BadMethodCallException('Bad method call');
    }
}

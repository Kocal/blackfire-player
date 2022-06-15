<?php

/*
 * This file is part of the Blackfire Player package.
 *
 * (c) Fabien Potencier <fabien@blackfire.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Blackfire\Player\Step;

/**
 * @author Fabien Potencier <fabien@blackfire.io>
 *
 * @internal
 */
final class StepContext
{
    private $auth;
    private $headers = [];
    private $wait;
    private $json;
    private $endpoint;
    private $followRedirects;
    private $variables = [];
    private $blackfire;
    private $blackfireRequest;
    private $blackfireScenario;
    private $samples;
    private $warmup;
    private $workingDir;

    public function update(ConfigurableStep $step, array $variables)
    {
        $this->workingDir = $step->getFile() ? rtrim(\dirname($step->getFile()), '/').'/' : null;

        if (null !== $step->getWait()) {
            $this->wait = $step->getWait();
        }

        if (null !== $step->getAuth()) {
            $this->auth = $step->getAuth();
        }

        if (null !== $step->isJson()) {
            $this->json = $step->isJson();
        }

        if (null !== $step->isFollowingRedirects()) {
            $this->followRedirects = $step->isFollowingRedirects();
        }

        foreach ($step->getHeaders() as $header) {
            $this->headers[] = $header;
        }

        if (null !== $step->getBlackfire()) {
            $this->blackfire = $step->getBlackfire();
        }

        if (null !== $step->getBlackfireRequest()) {
            $this->blackfireRequest = $step->getBlackfireRequest();
        }

        if (null !== $step->getBlackfireScenario()) {
            $this->blackfireScenario = $step->getBlackfireScenario();
        }

        if (null !== $step->getSamples()) {
            $this->samples = $step->getSamples();
        }

        if (null !== $step->getWarmup()) {
            $this->warmup = $step->getWarmup();
        }

        if ($step instanceof BlockStep) {
            if (null !== $step->getEndpoint()) {
                $this->endpoint = $step->getEndpoint();
            }

            foreach ($variables as $key => $value) {
                $this->variables[$key] = $value;
            }
        }
    }

    /**
     * @param string $value Must be an expression
     *
     * @internal
     */
    public function variable($key, $value)
    {
        $this->variables[$key] = $value;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getAuth()
    {
        return $this->auth;
    }

    public function getWait()
    {
        return $this->wait;
    }

    public function isFollowingRedirects()
    {
        return null === $this->followRedirects ? 'false' : $this->followRedirects;
    }

    public function isJson()
    {
        return null === $this->json ? 'false' : $this->json;
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getVariables()
    {
        return $this->variables;
    }

    public function getBlackfireEnv()
    {
        return $this->blackfire;
    }

    public function getBlackfireRequest()
    {
        return $this->blackfireRequest;
    }

    public function getBlackfireScenario()
    {
        return $this->blackfireScenario;
    }

    public function getSamples()
    {
        return null === $this->samples ? 1 : $this->samples;
    }

    public function getWarmup()
    {
        return null === $this->warmup ? 'true' : $this->warmup;
    }

    public function getWorkingDir()
    {
        return $this->workingDir;
    }
}

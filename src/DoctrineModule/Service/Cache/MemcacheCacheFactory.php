<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace DoctrineModule\Service\Cache;

use Doctrine\Common\Cache\MemcacheCache;
use DoctrineModule\Options\Cache\MemcacheCacheOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class MemcacheCacheFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     * @return Application
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        if (isset($config['doctrine']['cache']['memcache'])) {
            $config = $config['doctrine']['cache']['memcache'];
            if (is_string($config['instance'])) {
                $config['instnace'] = $serviceLocator->get($config['instance']);
            }
            $options = new MemcacheCacheOptions($config);
        } else {
            $options = new MemcacheCacheOptions();
        }

        $instance = new MemcacheCache;
        $instance->setNamespace($options->getNamespace());
        $instance->setMemcache($options->getInstance());

        return $instance;
    }
}
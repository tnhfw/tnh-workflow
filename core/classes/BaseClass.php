<?php
    defined('ROOT_PATH') || exit('Access denied');
    /**
     * TNH Framework
     *
     * A simple PHP framework using HMVC architecture
     *
     * This content is released under the MIT License (MIT)
     *
     * Copyright (c) 2017 TNH Framework
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in all
     * copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
     * SOFTWARE.
     */

    class BaseClass {
        /**
         * The logger instance
         * @var object
         */
        protected $logger = null;

        /**
         * Class constructor
         */
        public function __construct() {
            //Set default Log instance to use
            $this->logger = & class_loader('Log', 'classes');
            $this->logger->setLogger('Class::' . get_class($this));
        }

        /**
         * Set this class dependency instance using class_loader function
         * @param string $name this class property name.
         * @param string $className the name of class to load using class_loader function.
         * @param string $classPath the path of class to load using class_loader function.
         *
         * @return object the current instance
         */
        protected function setDependency($name, $className, $classPath = 'classes') {
            $this->{$name} = & class_loader($className, $classPath);
            return $this;
        }

        /**
         * Return the Log instance
         * @return object
         */
        public function getLogger() {
            return $this->logger;
        }

        /**
         * Set the log instance
         * @param object $logger the log object
         * @return object the current instance 
         */
        public function setLogger($logger) {
            $this->logger = $logger;
            return $this;
        }

    }

<?php
    /**
     * @Author : a.zinovyev
     * @Package: beansclient
     * @License: http://www.opensource.org/licenses/mit-license.php
     */

    namespace xobotyi\beansclient\Command;

    use xobotyi\beansclient\Exception;
    use xobotyi\beansclient\Interfaces;
    use xobotyi\beansclient\Response;

    class Bury extends CommandAbstract
    {
        private $jobId;
        private $priority;

        public
        function __construct(int $jobId, int $priority) {
            if ($jobId <= 0) {
                throw new Exception\Command('Job id should be a positive integer');
            }
            if ($priority < 0 || $priority > Put::MAX_PRIORITY) {
                throw new Exception\Command('Job priority must be between 0 and ' . Put::MAX_PRIORITY);
            }

            $this->commandName = Interfaces\Command::BURY;

            $this->jobId    = $jobId;
            $this->priority = $priority;
        }

        public
        function getCommandStr() :string {
            return $this->commandName . ' ' . $this->jobId . ' ' . $this->priority;
        }

        public
        function parseResponse(array $reponseHeader, ?string $reponseStr) :bool {
            if ($reponseHeader[0] === Response::BURIED) {
                return true;
            }
            else {
                throw new Exception\Command("Got unexpected status code [${reponseHeader[0]}]");
            }
            // ToDo: make handle of NOT_FOUND status
        }
    }
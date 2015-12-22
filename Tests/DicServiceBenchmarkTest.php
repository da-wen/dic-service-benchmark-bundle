<?php
namespace Dawen\Bundle\DicServiceBenchmarkBundle;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DicServiceBenchmarkTest extends WebTestCase
{
    public function testServices()
    {
        $ignoreServices = [];
        $client = static::createClient();
        $collect = [];
        $warnings = [];

        if (isset($GLOBALS['dic-service-benchmark-ignore'])) {
            $ignoreServices = explode(',', $GLOBALS['dic-service-benchmark-ignore']);
        }

        foreach($client->getContainer()->getServiceIds() as $serviceId) {
                $startedAt = microtime(true);
                $service = $client->getContainer()->get($serviceId);
                $elapsed = (microtime(true) - $startedAt) * 1000;

                $collect[] = $this->createEntry($serviceId, $elapsed);
                if ($elapsed >= 50) {
                    if(!empty($ignoreServices) && !in_array($serviceId, $ignoreServices)) {
                        $warnings[] = $this->createEntry($serviceId, $elapsed);
                    }
                }
        }

        echo PHP_EOL . PHP_EOL;

        echo 'List of all services and their time elapsed for instantiating them';

        echo PHP_EOL . PHP_EOL;

        $this->outputHeader();
        $this->output($collect);

        if (count($warnings) > 0) {
            echo PHP_EOL . PHP_EOL;

            echo '-------------------------------------------------' . PHP_EOL .PHP_EOL;
            echo 'Warning !!! This services taking longer than 50ms';

            echo PHP_EOL. PHP_EOL;

            $this->outputHeader();
            $this->output($warnings);

            echo PHP_EOL . '-------------------------------------------------' . PHP_EOL .PHP_EOL;

            $this->fail('Services taking longer than 50ms to be instantiated');
        }

    }

    /**
     * Create single entry array by values
     *
     * @param string $serviceId
     * @param float $elapsed
     *
     * @return array
     */
    private function createEntry($serviceId, $elapsed)
    {
        return [
            'service_id' => $serviceId,
            'time_elapsed' => $elapsed
        ];
    }

    /**
     * Sorts the list and echoes everything
     *
     * @param array $entries
     */
    private function output(array $entries)
    {
        $this->sort($entries);

        foreach($entries as $entry) {
            echo sprintf("%012.8f", $entry['time_elapsed']) . ' ' . $entry['service_id'] . PHP_EOL;
        }

    }

    /**
     * Sorts the entries by time_elapsed
     *
     * @param array $entries
     */
    private function sort(array &$entries)
    {
        usort($entries, function(array $a, array $b){
            return $b['time_elapsed'] - $a['time_elapsed'];
        });
    }

    /**
     * Echoes the header
     */
    private function outputHeader()
    {
        echo 'Elapsed (ms) Service ID' . PHP_EOL;
        echo '------------ ----------' . PHP_EOL;
    }
}

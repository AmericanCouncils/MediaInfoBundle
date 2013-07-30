<?php

namespace AC\MediaInfoBundle;

use Symfony\Component\Process\Process;

/**
 * Wraps the mediainfo utility to output other formats for programming against.
 *
 * @package ACMediaInfoBundle
 * @author Evan Villemez
 */
class MediaInfo
{
    protected $path;

    /**
     * Constructor requires path to mediainfo executable.
     *
     * @param string $path Path to executable
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Scans a file to return any structured metadata.
     *
     * @param  string $filepath Path to file to analyze
     * @return array
     */
    public function scan($filepath)
    {
        $proc = new Process(sprintf('%s %s --Output=XML --Full', $this->path, $filepath));
        $proc->run();

        if (!$proc->isSuccessful()) {
            throw new \RuntimeException($proc->getErrorOutput());
        }

        $result = $proc->getOutput();

        //parse structure to turn into raw php array
        $xml = simplexml_load_string($result);
        $data = array();
        $data['version'] = (string) $xml['version'];
        $data['file'] = array();

        foreach ($xml->File->track as $track) {
            $data['file'][strtolower($track['type'])] = array();

            foreach ($track as $key => $val) {
                $data['file'][strtolower($track['type'])][strtolower($key)] = (string) $val;
            }
        }

        return $data;
    }
}

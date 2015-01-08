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
     * Constructor accepts path to mediainfo executable.
     *
     * @param string $path Path to executable
     */
    public function __construct($path = 'mediainfo')
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

        foreach ($xml->File->track as $track) {
            $trackType = strtolower($track['type']);
            $trackId = isset($track['streamid']) ? $track['streamid'] : 1;
            $trackId = (string)$trackId;

            $trackData = [];
            foreach ($track as $rawKey => $rawVal) {
                $key = strtolower($rawKey);
                $val = (string)$rawVal;

                # This sometimes doesn't match streamid, so let's ignore it
                if ($key == 'stream_identifier') { continue; }

                if (!array_key_exists($key, $trackData)) {
                    $trackData[$key] = array($val);
                } elseif (!in_array($val, $trackData[$key])) {
                    $trackData[$key][] = $val;
                }
            }

            if ($trackType == 'general') {
                $data['file']['general'] = $trackData;
            } else {
                $data['file'][$trackType][$trackId] = $trackData;
            }
        }

        return $data;
    }
}

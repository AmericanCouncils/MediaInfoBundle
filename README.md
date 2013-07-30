# MediaInfoBundle #

This bundle provides a wrapper around the command line utility [mediainfo](http://mediaarea.net/en/MediaInfo).  This utility lets you get metadata about various multimedia formats.

For this bundle to work you must, of course, have `mediainfo` installed on your system.

## Installation ##

Require in your `composer.json`:

```json
{
  "require": {
    "ac/media-info-bundle": "~1.1.0"
  }
}
```

Add to your `AppKernel.php`;

```php
public function registerBundles()
{
    return array(
    //...
        new AC\MediaInfoBundle\ACMediaInfoBundle(),
    //...
    );
}
```

## Configuration ##

Configuration is very simple, you only need to provide the path to the `mediainfo` executable:

```yml
ac_media_info:
    path: /usr/bin/mediainfo
```

## Usage ##

Usage is equally simple:

```php
$mediainfo = $container->get('ac.mediainfo');

//will return a structured php array with the mediainfo results
$array = $mediainfo->scan('/path/to/file.mp4');
```
All keys returned by `mediainfo` are normalized to lower-case.  For example, the following calls:

```php
$data = $mediainfo->scan('/path/to/sample.webm');
print_r($data);
```
    
Would result in:

```
Array
(
    [version] => 0.7.63
    [file] => Array
        (
            [general] => Array
                (
                    [count] => 284
                    [count_of_stream_of_this_kind] => 1
                    [kind_of_stream] => General
                    [stream_identifier] => 0
                    [unique_id] => 94077224337973666327274415816295077565 (0x46C69D45A185A9294D3D0A2F750056BD)
                    [count_of_video_streams] => 1
                    [count_of_audio_streams] => 1
                    [video_format_list] => VP8
                    [video_format_withhint_list] => VP8
                    [codecs_video] => V_VP8
                    [video_language_list] => English
                    [audio_format_list] => Vorbis
                    [audio_format_withhint_list] => Vorbis
                    [audio_codecs] => Vorbis
                    [audio_language_list] => English
                    [complete_name] => /Users/evan/Desktop/trailer.webm
                    [folder_name] => /Users/evan/Desktop
                    [file_name] => trailer
                    [file_extension] => webm
                    [format] => WebM
                    [format_url] => http://www.webmproject.org/
                    [format_extensions_usually_used] => webm
                    [commercial_name] => WebM
                    [format_version] => Version 1
                    [internet_media_type] => video/webm
                    [codec] => WebM
                    [codec_url] => http://www.webmproject.org/
                    [codec_extensions_usually_used] => webm
                    [file_size] => 2.065 MiB
                    [duration] => 00:00:32.480
                    [overall_bit_rate_mode] => Variable
                    [overall_bit_rate] => 533 Kbps
                    [stream_size] => 119 KiB (6%)
                    [proportion_of_this_stream] => 0.05621
                    [encoded_date] => UTC 2010-05-20 08:21:12
                    [file_last_modification_date] => UTC 2013-07-26 20:20:20
                    [file_last_modification_date__local_] => 2013-07-26 16:20:20
                    [writing_application] => Sorenson Squeeze
                    [writing_library] => http://sourceforge.net/projects/yamka
                )

            [video] => Array
                (
                    [count] => 263
                    [count_of_stream_of_this_kind] => 1
                    [kind_of_stream] => Video
                    [stream_identifier] => 0
                    [streamorder] => 0
                    [id] => 1
                    [unique_id] => 38308775201223106
                    [format] => VP8
                    [format_url] => http://www.webmproject.org/
                    [commercial_name] => VP8
                    [codec_id] => V_VP8
                    [codec_id_url] => http://www.webmproject.org/
                    [codec] => V_VP8
                    [duration] => 00:00:32.480
                    [bit_rate] => 439 Kbps
                    [width] => 640 pixels
                    [height] => 360 pixels
                    [pixel_aspect_ratio] => 1.000
                    [display_aspect_ratio] => 16:9
                    [frame_rate_mode] => Constant
                    [frame_rate] => 25.000 fps
                    [frame_count] => 812
                    [compression_mode] => Lossy
                    [bits__pixel_frame_] => 0.076
                    [delay] => 00:00:00.000
                    [delay__origin] => Container
                    [stream_size] => 1.70 MiB (82%)
                    [proportion_of_this_stream] => 0.82378
                    [language] => en
                    [default] => Yes
                    [forced] => No
                )

            [audio] => Array
                (
                    [count] => 220
                    [count_of_stream_of_this_kind] => 1
                    [kind_of_stream] => Audio
                    [stream_identifier] => 0
                    [streamorder] => 1
                    [id] => 2
                    [unique_id] => 110618262945856186
                    [format] => Vorbis
                    [format_url] => http://www.vorbis.com/
                    [commercial_name] => Vorbis
                    [format_settings__floor] => 1
                    [internet_media_type] => audio/vorbis
                    [codec_id] => A_VORBIS
                    [codec_id_url] => http://www.vorbis.com
                    [codec] => Vorbis
                    [codec_family] => Vorbis
                    [codec_url] => http://www.vorbis.com
                    [codec_settings__floor] => 1
                    [duration] => 00:00:32.480
                    [bit_rate_mode] => Variable
                    [bit_rate] => 64.0 Kbps
                    [channel_s_] => 1 channel
                    [sampling_rate] => 44.1 KHz
                    [samples_count] => 1432368
                    [compression_mode] => Lossy
                    [delay] => 00:00:00.000
                    [delay__origin] => Container
                    [delay_relative_to_video] => 0
                    [video0_delay] => 0
                    [stream_size] => 254 KiB (12%)
                    [proportion_of_this_stream] => 0.12001
                    [writing_library] => libVorbis (Everywhere) (20100325 (Everywhere))
                    [writing_library_name] => libVorbis
                    [writing_library_version] => (Everywhere)
                    [writing_library_date] => 20100325 (Everywhere)
                    [language] => en
                    [default] => Yes
                    [forced] => No
                )

        )

)

```

## Command ##

The `mediainfo:scan` command will let you export the results of a scan in yaml or json.

    app/console mediainfo:scan --format=json /path/to/file.webm
    

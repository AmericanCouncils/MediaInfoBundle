# MediaInfoBundle #

This bundle provides a wrapper around the command line utility [mediainfo](http://mediaarea.net/en/MediaInfo).  This utility lets you get metadata about various multimedia formats.

For this bundle to work you must, of course, have `mediainfo` installed on your system.

## Configuration ##

Configuration is very simple, you only need to provide the path to the `mediainfo` executable:

```yml
ac_mediainfo:
    path: /path/to/mediainfo
```

## Usage ##

Usage is equally simple:

```php
$mediainfo = $container->get('ac.mediainfo');

//will return a structure php array containing the result data
$array = $mediainfo->scan('/path/to/file.mp4');

//you can also return other formats:
$string = $mediainfo->scan('/path/to/file.mp4', 'xml');
$string = $mediainfo->scan('/path/to/file.mp4', 'yaml');
$string = $mediainfo->scan('/path/to/file.mp4', 'json');
```


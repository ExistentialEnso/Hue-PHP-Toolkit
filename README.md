Hue PHP Toolkit
=====================

* Author: Thorne Melcher (GitHub: ExistentialEnso)
* License: LGPL v3 (more permissive commercial licensing available for a fee on request)
* Version: 0.2

Toolkit to make working with the Philips Hue light system easier in PHP, featuring a heavily object-oriented design
with a focus on code readability.

To dive in, all you need to do is pass the the bridges IP address and an admin username to the constructor for Bridge.
If you have not setup a user account with your bridge, refer to the "Getting Started" part of Philips' API guide.

```
   $bridge = new \hue\models\Bridge("192.168.1.99", "admin");
```

Which allows you to easily manipulate your lights via PHP. For instance, you can turn off all of your lights with just
one simple line:

```
  $bridge->setAllOff();
```

Or you can turn them all on almost as easily setting up a basic state.

```
   $state = new \hue\models\State();
   $state->setIsOn(true);
   $state->setBrightness(255); //maximum brightness
   $state->setSaturation(0); //no color filtering
   $bridge->setAllToState($state);
```

### Version History

#### v0.2 (Released 8/14/13)
* Added ->setHexCode() to LightState which approximates a light color from an HTML/CSS hex code (e.g. #FF0000)
* Added ->setNamedColor() to LightState which sets the lights to any of the standard 141 web named colors (some work better than others)
* Fixed some minor bugs.
* Added more code documentation.
* Laid some more groundwork in the Group model.


# md-site - A static site provider with superpowers

Take some markdown, spice that with a bit of logic-less mustache and combine the
whole thing with some html and css from a framework of your choice. And this is
what you get: *md-site*! A small pice of software that allows the use of
markdown files as static pages.

It's lightweight, highly configurable and adaptable at the same time.

## Getting Started

There is very little you'll have to do to set up your very own copy of md-site.

### Prequisites

 * A working composer installation
 * A global installation of bower (along with node)
   `npm install -g bower`

 * A webserver running php 5.4 or higher
 * A text editor, best case with syntax highlighting support

### Useful to have later

 * A global node-sass installation
   `npm install -g node-sass`; it allows you to easyly convert your sass/scss
   like it's shown [here](http://stackoverflow.com/a/31448585/2557685)

### Installation

```
# clone this repo; or alternatively downlad the zip
git clone https://github.com/GameplayJDK/md-site.git

cd md-site/

# install composer dependencies
composer install

# install bower dependencies
bower install

# start your php server to test if everything works
php -S localhost:8000 ./default.php
# visit localhost:8000 to check
```

And you're all set up to get started with development:
 * Set an icon by creating an `icon.png` file
 * Manage the settings in `app/config.php` and `app/custom_data.php`
 * Design your own `template.html` page, [furtive](http://furtive.co/),
   [jQuery](https://github.com/jquery/jquery) and
   [font-awesome](http://fontawesome.io/icons/) are preinstalled in this case,
   for further information on template development have a look at
   [this](https://github.com/bobthecow/mustache.php/wiki/Mustache-Tags)
   [\*](https://mustache.github.io/mustache.5.html) and
   [this](https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet)
 * Put your php code into the `app/lib/` directory
 * Place any kind of other resources in `res/`

### Configuration

*Note: Config allows all values from [Slim Default Settings](https://www.slimframework.com/docs/objects/application.html#slim-default-settings)*.

 * `displayErrorDetails`: (Slim)
   When true, additional information about exceptions are displayed. Use this
   while testing.
   (Default: `true`)
 * `addContentLengthHeader`: (Slim)
   When true, a `Content-Length` header will added to the response.
   (Default: `false`)
 * `converter` group:
   Contains settings related to [Parsedown](https://github.com/erusev/parsedown)
   as converter from markdown to html.
  * `defaultFileName`:
      The filename (without extension) for the "index" file.
      (Default: `default`)
  * `baseDirectory`:
      The public directory in which all content files are placed. Should be a
      subdirectory of the root directory. Notice the trailing slash.
      (Default: `./../public/`)
  * `fileExtension`:
      The file extension for content files. Notice the leading dot.
      (Default: `.md`)
 * `renderer` group:
   Contains settings related to
   [Mustache](https://github.com/bobthecow/mustache.php) as template solution.
  * `prerenderContent`:
      When true, the content of content files is prerendered internally before
      it's passed to the template rendering.
  * `templateFile`:
      The template file that should containing the html around content.
      (Default: `./../template.html`)
  * `customData` reference:
      Special case: This imports custom data for template rendering from
      `custom_data.php`. Do not change this, except you know what you're doing.
 * `overrideDefault`:
   When true, this redirects every request to the content file set in
   `converter.defaultFileName`. This is useful to simulate maintainance mode,
   which would only require a proper template and content file that's then set
   as `converter.defaultFileName`.
   (Default: `false`)
 * `exposeToXhr`:
   When true, the raw content file is returned to explicit Xhr requests without
   aplying anything else than preparsing if configured so in
   `renderer.prerenderContent`. This should not be enabled if content files
   contain html code. Results would then depend on the client.
   (Default: true)

#### The `customData` field

This configuration field has its own file, namely `custom_data.php`. This file
can contain any combination of key-value pairs that are supplied to the renderer
as `custom_data` top level property (mustache tag).

By default it only contains some meta tag values (`author`, `description`,
`keywords`) all set to `?`, but in a more complex scenario, it may contain
separate data for each type of site. For example menu data, contact information
or social links.

### Template development

Template development is essentially just html and css design combined with
[Mustache tags](https://mustache.github.io/mustache.5.html). There is no
markdown involved at this level. [Furtive](http://furtive.co/),
[jQuery](https://github.com/jquery/jquery) and
[font-awesome](http://fontawesome.io/icons/) are preinstalled for preference
reasons. It's easy to remove 'em with just a few commands.

The following is an example template that's almost too simple:

```
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />

    <title>{{ header }}</title>

    {{# custom_data }}
    <meta name="author" content="{{author}}" />
    <meta name="description" content="{{description}}" />
    <meta name="keywords" content="{{keywords}}" />
    {{/ custom_data }}

    <link rel="icon" type="image/png" href="/icon.png" />

    <link rel="stylesheet" type="text/css" href="/bower_components/furtive/css/furtive.css" />
    <link rel="stylesheet" type="text/css" href="/bower_components/font-awesome/css/font-awesome.css" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
    <!-- TODO -->
    {{ header }}

    {{{ content }}}

    <script type="text/javascript" src="/bower_components/jquery/dist/jquery.js">
    </script>
</body>
</html>
```

1. The title is set dynamically using a standard mustache tag.
2. Author, description and keywords are also set that way but inside a mustache
   block.
3. The content is inserted using an unescaped mustache tag.

**A somewhat important note:** There are predefined mustache tags.

 * `{{ file }}`: The full path to the current file.
 * `{{ header }}`: The capitalized file name.
 * `{{ content }}`: The file rendered content.
 * `{{ error }}`: An error message. Currently always `null`.
 * `{{ custom_data }}`: A data structure containing information as configured.
   For more details see the dedicated section above.

### Content files

Content files are the files placed in the publicly accessible folder that's
configured. These files are meant to contain raw markdown and can also contain
mustache tags, if `renderer.prerenderContent` is set accordingly. Beyond that
they're not initially compatible with the `exposeToXhr` option mentioned above
e.g. if they contain raw html code the client making the XHR has to deal with
that. Php code will not execute at all.

The principle behind content files is as simple as it's with templates except
that instead of html markdown should be used.

The files can be arranged in any file hierachy which allows subdirectories
visible in the url.

## Deployment

Deployment is very easy as well. Just like everything else with md-site.
(Currently only apache is supported out of the box, but other configurations can
be found [here](https://www.slimframework.com/docs/start/web-servers.html)).

Then just upload the contents of the root directory to your webservers content
root and that's it.

**Notice:** Currently the assets require md-site to be installed in your
webroot to load corectly. As this is dictated by the template code you can
always modify your template to fit your special needs.

### Local testing

In most cases you should test your template and newly written content files
before publshing by uploading them to your webserver. The easiest way to do so
is to use a locally installed private webserver and test your site there.

 * [XAMPP](https://www.apachefriends.org/download.html) (portable)

The procedure is the same as with a remote server: Just place the root directory
inside the webservers web root, for example at `htdocs/md-site` which would then
allow you to reach it under `http://localhost/md-site`.

This eases the deplayment process as you only have to sync the content of the
local and the remote directory.

## Built with

 * [Slim](https://github.com/slimphp/Slim) - Doing the heavy lifting
 * [Mustache.php](https://github.com/bobthecow/mustache.php) - Insert everything
   where it belongs
 * [Parsedown](https://github.com/erusev/parsedown) - Transform markdown into
   code

Preinstalled for template creation:

 * [Furtive](https://github.com/johnotander/furtive)
 * [jQuery](https://github.com/jquery/jquery)
 * [Font Awesome](https://github.com/FortAwesome/Font-Awesome)

## License

This project is licensed under the MIT License - see the
[LICENSE.md](https://github.com/GameplayJDK/md-site/blob/master/LICENSE.txt)
file for details.

Timber integration
==================

[Timber](https://github.com/jarednova/timber) integration class for Papi

## TimberImage

Papi has already initialized the images with `TimberImage` class. So instead of writing this:

```twig
<img src="{{TimberImage(item.picture).src}}" />
```

You can just write it like this:

```twig
<img src="{{item.picture.src}}" />
```
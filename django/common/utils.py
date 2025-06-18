from django.utils.text import slugify


def slugify_field(sender, instance, **kwargs):
    if hasattr(instance, "sluggable"):
        options = getattr(instance, "sluggable")()
        for destination, sluggable in options.items():
            slug = slugify(getattr(instance, sluggable["source"]))
            baseslug = slug
            count = 1

            if not getattr(instance, destination):

                while (
                    instance.__class__.objects.filter(
                        **{"%s__iexact" % destination: slug}
                    ).count()
                    > 0
                ):
                    slug = baseslug + "-" + str(count)
                    count += 1

                setattr(instance, destination, slug)


def intended(request, *args, **kwargs):
    from django.shortcuts import redirect

    if request.session.get("_previous.url"):
        path = request.session.get("_previous.url")
    else:
        if request.get_host() == request.META.get("HTTP_HOST").netloc:
            path = request.META.get("HTTP_REFERER", "/")
        else:
            path = "/"

    return redirect(path, *args, **kwargs)

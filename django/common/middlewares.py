class PreviousUrlMiddleware:
    def __init__(self, get_response):
        self.get_response = get_response

    def __call__(self, request):
        if (
            request.method == "GET"
            and not request.META.get("x-requested-with") == "XMLHttpRequest"
        ):
            request.session["_previous.url"] = request.META.get("HTTP_REFERER")

        response = self.get_response(request)

        return response

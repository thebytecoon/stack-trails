def search_query(request):
    search_query = ""

    if request.GET.get('search'):
        search_query = request.GET.get('search')

    return {
        "search_query": search_query
    }
def create(request, order_id, item_id):
    # Logic to create a review for the specified order and item
    return render(request, 'reviews/create.html', {'order_id': order_id, 'item_id': item_id})

def store(request, order_id, item_id):
    # Logic to store the review for the specified order and item
    return render(request, 'reviews/store.html', {'order_id': order_id, 'item_id': item_id})
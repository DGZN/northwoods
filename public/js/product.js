
class Product {

  constructor() {}

  setProduct(product) {
    this.product = product
    console.log("set product", this.product);
  }

  get details() {
    return this.product;
  }

  byID(id, cb) {
    var self = this;
    $.ajax({
      url: url + '/api/v1/products/' + id,
      success: function(product){
        self.setProduct(product)
        if (product.modifiers)
          return cb(product.modifiers)
      }
    })
  }

  getProductsByType(typeID, cb) {
    $.ajax({
      url: url + '/api/v1/product-types/' + typeID,
      success: function(data){
        return cb(data.products)
      }
    })
  }

}

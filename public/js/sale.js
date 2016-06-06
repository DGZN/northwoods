
class Sale {

  constructor(employee, saleTax) {
    this._items = [];
    this.costTotal  = 0;
    this.taxTotal   = 0;
    this.grandTotal = 0;
    this._saleID = 0;
    this._sale = {};
    this._transactions = [];
    this.saleTax = saleTax;
    this._employee = employee;
    this._transactedAmount = 0;
  }

  get employee() {
    return this._employee;
  }

  get lineItems() {
    return this._items;
  }

  get transactions() {
    return this._transactions;
  }

  set transaction(transaction) {
    this._transactions.push(transaction);
  }

  get saleID() {
    return this._saleID;
  }

  set saleID(id) {
    this._saleID = id;
  }

  get sale() {
    return this._sale;
  }

  set sale(sale) {
    this._sale = sale;
  }

  get transactedAmount() {
    return this._transactedAmount;
  }

  set transactedAmount(amount) {
    this._transactedAmount = parseFloat(amount).toFixed(2)
  }

  get bill() {
    return {
      cost: this.costTotal
    , tax: this.taxTotal
    , grand: this.grandTotal
    , transactedAmount: this.transactedAmount
    }
  }

  setLineItem(item) {
    this._items.push(item);
  }

  removeLineItem(index) {
    delete this._items[index]
  }

  calculateBill(cb) {
    var cost = 0;
    var tax = 0;
    var total = 0;
    this._items.forEach((product) => {
      cost += parseFloat(product.total)
    })
    tax = cost  / this.saleTax
    var total = (parseFloat(cost) + parseFloat(tax));
    this.costTotal  = parseFloat(cost).toFixed(2);
    this.taxTotal   = parseFloat(tax).toFixed(2);
    this.grandTotal = parseFloat(total).toFixed(2);
    return cb(this.bill)
  }

  createSale(data, cb) {
    var self = this;
    $.ajax({
      url: url + '/api/v1/sales',
      type: 'post',
      data:  {
        total: this.costTotal
        , tax: this.taxTotal
        , grand: this.grandTotal
        , employeeID: self.employee.id
        , corporateID: data.corporateID
        , notes: data.notes
      },
      success: function(data){
        if (data.id) {
          self.saleID = data.id
          self.sale = data;
          return cb(null)
        }
      },
      error: function(data){
        return cb(data.responseJSON)
      }
    })
  }

  processTransaction(transaction, cb) {
    var self = this;
    if ((parseFloat(this.transactedAmount) + parseFloat(transaction.total)) <= this.grandTotal) {
      this.transactedAmount = (parseFloat(transaction.total) + parseFloat(this.transactedAmount));
      transaction.saleID = this.saleID;
      $.ajax({
        url: url + '/api/v1/transactions',
        type: 'post',
        data:  transaction,
        success: function(data){
          self.transaction = data
          return cb(null, data)
        },
        error: function(data){
          return cb(data.responseJSON)
        }
      })
    }
  }

  completeSale(cb) {
    this.lineItems.map((product) => {
      product.saleID = this.saleID
      $.ajax({
        url: url + '/api/v1/sold-products',
        type: 'post',
        data:  product,
        success: function(data) {
          return cb(null, data)
        },
        error: function(data) {
          return cb(data.responseJSON)
        }
      })
    })
  }

}

$(document).ready(function () {
  // Load product list on page load
  loadProductList();
  var initialType = $('#productType').val();
  updateAdditionalAttributeField(initialType);

  // Open Add Product modal when Add button is clicked
  $('#add-btn').click(function () {
    window.location.href = 'add-product.html';
  });

  // Submit Add Product form
  $('#add-product-modal').on('submit', '#product-form', function (event) {
    event.preventDefault();
    addProduct();
   // window.location.href = 'index.html';
  });

  //Change additional-attribure fields
  $('#productType').on('change', function(){
    var selectedType = $('#product-type').val();
    updateAdditionalAttributeField(selectedType);
  })

  // Handle Mass Delete action
  $('#mass-delete-button').click(function () {
    deleteSelectedProducts();
  });
});

// Function to load the product list from the API
function loadProductList() {
  $.ajax({
    url: 'api.php',
    method: 'GET',
    dataType: 'json',
    success: function (response) {

      var productList = $('#product-list');
      productList.empty();

      if (response && response.product.length > 0) {
        $.each(response.product, function(index, product) {

          var item = $('<div>').addClass('product-item');
          item.append('<input type="checkbox" class="delete-checkbox" value="' + product.id + '">');
          item.append('<span class="sku"> SKU: ' + product.sku + '</span>');
          item.append('<span class="name"> NAME: ' + product.name + '</span>');
          item.append('<span class="type"> TYPE: ' + product.type + '</span>');
          item.append('<span class="price"> PRICE: ' + product.price + '$' + '</span>');
          if(product.type === 'DVD') {
            item.append('<span class="additional-info"> SIZE(MB): ' + product.size + '</span>');
          } else if(product.type === 'Book') {
            item.append('<span class="additional-info"> Weight(KG): ' + product.weight + '</span>');
          } else if(product.type === 'Furniture') {
            item.append('<span id="height"> Height:' + product.height + '</span>');
            item.append('<span id="width"> Width: '  + product.width + '</span>');
            item.append('<span id="length"> Length: ' + product.length + '</span>');
          }
          productList.append(item);
        });
      } else {
        productList.append('<div class="empty-message">No products found</div>');
      }
    },
    error: function () {
      console.log('Error occurred while loading the product list');
    }
  });
}

// Function to update the additional attribute field based on the selected product type
function updateAdditionalAttributeField(type) {
  var additionalAttributeField = $('#additional-attribute');
  additionalAttributeField.empty();
  if (type === 'DVD') {
    additionalAttributeField.append($('<label>').text('Size (MB):'));
    additionalAttributeField.append($('<input>').attr('type', 'number').attr('id', 'size').attr('required', 'required'));
  } else if (type === 'Book') {
    additionalAttributeField.append($('<label>').text('Weight (Kg):'));
    additionalAttributeField.append($('<input>').attr('type', 'number').attr('id', 'weight').attr('required', 'required'));
  } else if (type === 'Furniture') {
    additionalAttributeField.append($('<label>').text('Height:'));
    additionalAttributeField.append($('<input>').attr('type', 'number').attr('id', 'height').attr('required', 'required'));
    additionalAttributeField.append($('<label>').text('Width:'));
    additionalAttributeField.append($('<input>').attr('type', 'number').attr('id', 'width').attr('required', 'required'));
    additionalAttributeField.append($('<label>').text('Length:'));
    additionalAttributeField.append($('<input>').attr('type', 'number').attr('id', 'length').attr('required', 'required'));
  }
}

// Function to close the Add Product modal
function closeAddProductModal() {
  $('#add-product-modal').hide();
}

// Function to add a new product
function addProduct() {
  var sku = $('#sku').val();
  var name = $('#name').val();
  var price = $('#price').val();
  var productType = $('#productType').val();

  var productData;

  if (productType === 'DVD') {
    productData = {
      sku: sku,
      name: name,
      price: price,
      productType: productType,
      size: $('#size').val(),
    }
  }
  if (productType === 'Book') {
      productData = {
        sku: sku,
        name: name,
        price: price,
        productType: productType,
        weight: $('#weight').val(),
      }
    }
  if (productType === "Furniture") {
    productData = {
      sku: sku,
      name: name,
      price: price,
      productType: productType,
      height: $('#height').val(),
      width: $('#width').val(),
      length: $('#length').val(),
    }
  }

  $.ajax({
    url: 'api.php',
    method: 'POST',
    data: JSON.stringify(productData),
    success: function (response) {
      // Handle the success response
      closeAddProductModal();
      loadProductList();
    },
    error: function () {
      console.log('Error occurred while adding the product');
    }
  });
}

// Function to delete the selected products
function deleteSelectedProducts() {
  var selectedProducts = [];
  $('.delete-checkbox:checked').each(function () {
    var id = $(this).val();
    selectedProducts.push(id);
  });
  if (selectedProducts.length === 0) {
    alert('Please select at least one product to delete');
    return;
  }
  var confirmDelete = confirm('Are you sure you want to delete the selected products?');
  if (!confirmDelete) {
    return;
  }
  var deleteData = {
    products: selectedProducts
  };
  $.ajax({
    url: 'api.php',
    method: 'DELETE',
    data: JSON.stringify(deleteData),
    success: function (response) {
      // Handle the success response
      loadProductList();
    },
    error: function () {
      console.log('Error occurred while deleting the products');
    }
  });
}

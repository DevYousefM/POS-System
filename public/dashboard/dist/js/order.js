$(document).ready(function () {


    const products = [];
    $(".add-product-btn").on("click", function (e) {
        e.preventDefault();
        let name = $(this).data("name"), id = $(this).data("id"), price = $(this).data("price");
        $(this).removeClass("btn-success").addClass("btn-outline-dark disabled");


        let html = `
                <tr>
                    <td>
                        ${name}
                    </td>
                    <td>
                        <input type="number" name="products[${id}][quantity]" data-price="${price}" min="1" value="1" class="form-control text-center product-quantity" style="width: 60px">
                    </td>
                    <td class="product-price">
                        ${price}
                    </td>
                    <td>
                        <button class="btn btn-danger remove-product-btn" data-id=${id}><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`;
        if (!products.includes(id)) {
            products.push(id);
            $(".order-list").append(html);
            calculateTotal()
        }

    })
    $("body").on("click", ".remove-product-btn", function (e) {
        e.preventDefault();

        var id = $(this).data("id");
        const i = products.indexOf(id);
        products.splice(i, 1);
        $("#product-" + id).removeClass("btn-outline-dark disabled").addClass("btn-success");
        $(this).closest("tr").remove();
        calculateTotal()
    });


    let globalTotal = 0;

    function calculateTotal() {
        let total = 0;
        $(".order-list .product-price").each(function (i) {
            total += parseFloat($(this).html().replace(/,/g, ""));
        });
        $("#total").html(total).number(true, 2);

        if (total > 0) {
            $("#add-order").removeClass("disabled");
            $("#add-order").css("cursor", "pointer");
        } else {
            $("#add-order").addClass("disabled");
            $("#add-order").css("cursor", "not-allowed");
        }
        globalTotal = total;
    }

    $("#add-order").on("click", function (e) {
        globalTotal > 0 ? null : e.preventDefault();
    });

    $("body").on("keyup change", ".product-quantity", function () {
        const quantity = Number($(this).val());
        const productPrice = $(this).data("price");
        $(this).closest("tr").find(".product-price").html(productPrice * quantity).number(true, 2);
        calculateTotal();

    });
    $("body").on("keyup change", "#discount", function () {
        if (globalTotal > 0) {
            $("#total").html(globalTotal - $(this).val()).number(true, 2);
        }
    });

    $(".show-products-btn").on("click", function (e) {
        e.preventDefault();
        let url = $(this).data("url"), method = $(this).data("method"),
            loader = `<div id="loader"><div class="lds-dual-ring"></div></div>`;

        $("#order-product-list").empty();
        $("#order-product-list").prepend(loader);
        $.ajax({
            url: url,
            method: method,
            success: function (data) {
                $("#order-product-list").append(data);
                $("#order-product-list").find("#loader").remove();
            }
        })
    });
    $(".edit-order") ? calculateTotal() : null;

});

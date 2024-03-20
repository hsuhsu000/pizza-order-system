$(document).ready(function () {
    $(".btn-plus").click(function () {
        $parentNode = $(this).parents("tr");
        $price = Number($parentNode.find("#price").text().replace("Kyats", ""));
        $qty = Number($parentNode.find("#qty").val());

        //total
        $total = $price * $qty;
        $parentNode.find("#total").html($total + " Kyats");

        SummaryCalculation();
    });

    $(".btn-minus").click(function () {
        $parentNode = $(this).parents("tr");
        $price = Number($parentNode.find("#price").text().replace("Kyats", ""));
        $qty = Number($parentNode.find("#qty").val());

        //total
        $total = $price * $qty;
        $parentNode.find("#total").html($total + " Kyats");

        SummaryCalculation();
    });

    function SummaryCalculation() {
        //subtotalprice
        $totalPrice = 0;
        $("#dataTable tbody tr").each(function (index, row) {
            $totalPrice += Number(
                $(row).find("#total").text().replace("Kyats", "")
            );
        });

        $("#subTotalPrice").html(`${$totalPrice} Kyats`);
        $("#finalPrice").html(`${$totalPrice + 3000} Kyats`);
    }
});

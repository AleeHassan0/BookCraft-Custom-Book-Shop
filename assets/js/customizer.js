document.addEventListener("DOMContentLoaded", function () {

    const optionSelects = document.querySelectorAll(
        ".book-option-select"
    );

    const totalPriceElement = document.getElementById(
        "total-price"
    );

    const totalPriceDisplay = document.getElementById(
        "total-price-display"
    );

    if (!totalPriceElement) {
        return;
    }

    const basePrice = parseFloat(
        totalPriceElement.dataset.basePrice
    );

    function calculatePrice() {

        let total = basePrice;

        optionSelects.forEach(function (select) {

            const selectedOption =
                select.options[select.selectedIndex];

            const extraPrice = parseFloat(
                selectedOption.dataset.price
            ) || 0;

            total += extraPrice;

        });

        totalPriceElement.textContent =
            "€" + total.toFixed(2);

        if (totalPriceDisplay) {
            totalPriceDisplay.textContent =
                "€" + total.toFixed(2);
        }

    }

    optionSelects.forEach(function (select) {

        select.addEventListener("change", calculatePrice);

    });

    calculatePrice();

});
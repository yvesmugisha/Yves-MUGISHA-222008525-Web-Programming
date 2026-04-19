const amountInput = document.getElementById("amount");
const currencySelect = document.getElementById("currency");
const rateInput = document.getElementById("rate");
const convertButton = document.getElementById("convertButton");
const resultText = document.getElementById("resultText");

convertButton.addEventListener("click", () => {
  const amount = parseFloat(amountInput.value);
  const rate = parseFloat(rateInput.value);
  const currency = currencySelect.value;

  if (Number.isNaN(amount) || amount < 0) {
    resultText.textContent = "Please enter a valid amount.";
    return;
  }

  if (Number.isNaN(rate) || rate <= 0) {
    resultText.textContent = "Please enter a valid exchange rate.";
    return;
  }

  const converted = amount / rate;
  const formattedAmount = converted.toLocaleString(undefined, {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });

  resultText.textContent = `${amount} � ${rate} = ${formattedAmount} ${currency}`;
});

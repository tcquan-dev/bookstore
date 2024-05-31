document.getElementById("generate-btn").addEventListener("click", function () {
    const generatedCode = generateRandomString(8);
    document.querySelector('.form-control[name="code"]').value = generatedCode;
});

function generateRandomString(length) {
    const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    let result = "";
    for (let i = 0; i < length; i++) {
        result += characters.charAt(
            Math.floor(Math.random() * characters.length)
        );
    }
    return result;
}

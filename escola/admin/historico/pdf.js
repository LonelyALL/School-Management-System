const button = document.getElementById("pdfGenerate");

button.addEventListener("click", () =>{

    const content = document.getElementById("content");
    const options = {
        margin: [0, 0, 0, 0],
        filename: "historico.pdf",
        html2canvas: { scale: 1 },
        jsPDF: { unit: "mm", format: "a3", orientation: "portrait" },
        pagebreak: { after: '.breakDiv' }
    }

    html2pdf().set(options).from(content).save();
});

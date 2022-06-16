function json_to_table(data) {
    let text = "<table border='1'>";
    let keys = Object.keys(data[0]);
    for (let k of keys) {
        text += "<th>" + k + "</th>"
    }
    for (let x of data) {
        let values = Object.values(x);
        text += "<tr>";
        values.forEach((v, i) => {
            text += "<td>" + v + "</td>";
        });
        text += "</tr>";
    }
    text += "</table>"
    return text;
}

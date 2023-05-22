$(document).ready(function () {
  $.ajax({
    url: "./patients.xml", // Adresa URL de unde se încarcă fișierul XML cu pacienți
    dataType: "text", // Tipul de date pe care îl aștepți de la server (în acest caz, text)
  })
    .done(function (data) {
      const xmlDoc = $.parseXML(data); // Parsarea datelor XML primite de la server într-un obiect XML
      const $xml = $(xmlDoc);

      const patients = $xml.find("patient"); // Găsirea tuturor elementelor "patient" în obiectul XML
      const $tableBody = $("#patients-table tbody"); // Obținerea referinței către corpul tabelului

      patients.each(function () {
        const $patient = $(this); // Referința către elementul "patient" curent

        // Extrage informațiile despre pacient din elementul curent
        const id = $patient.find("id").text();
        const firstName = $patient.find("first_name").text();
        const lastName = $patient.find("last_name").text();
        const age = $patient.find("age").text();
        const address = $patient.find("address").text();
        const email = $patient.find("email").text();
        const cellPhone = $patient.find("cell_phone").text();
        const diagnosis = $patient.find("diagnosis").text();

        // Construiește un rând HTML pentru tabelul pacienților, utilizând informațiile extrase
        const row = `<tr>
                      <td>${id}</td>
                      <td>${firstName}</td>
                      <td>${lastName}</td>
                      <td>${age}</td>
                      <td>${address}</td>
                      <td>${email}</td>
                      <td>${cellPhone}</td>
                      <td>${diagnosis}</td>
                    </tr>`;
        $tableBody.append(row); // Adaugă rândul în corpul tabelului
      });
      $("#patients-table").hide().fadeIn(100); // Ascunde și apoi afișează tabelul cu efect de fundal
    })
    .fail(function (error) {
      console.error(error); // În cazul în care apelul Ajax nu reușește, afișează eroarea în consolă
    });
});

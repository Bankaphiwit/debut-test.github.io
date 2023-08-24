jQuery(document).ready(function (e) {
  formSubmit();
});

function formSubmit() {
  jQuery("#formAddEmployee").on("submit", function (e) {
    const code = jQuery("#empNum").val().trim();
    const name = jQuery("#empName").val().trim();
    const position = jQuery("#empPosition").val();
    let error = false;
    if (isEmpty(code)) error = "คุณยังไม่ได้กรอกรหัสพนักงาน";
    if (isEmpty(name)) error = "คุณยังไม่ได้กรอกชื่อพนักงาน";
    if (isEmpty(position)) error = "คุณยังไม่ได้เลือกตำแหน่ง";

    if (error) {
      alert(error);
      e.preventDefault();
      return false;
    }
  });
}

function isEmpty(value) {
  if (value === null || value === undefined) {
    return true;
  }

  if (typeof value === "string" && value.trim() === "") {
    return true;
  }

  if (Array.isArray(value) && value.length === 0) {
    return true;
  }

  if (typeof value === "object" && Object.keys(value).length === 0) {
    return true;
  }

  return false;
}

// 学習用：大原則として、フロントでの値のチェックは、あくまでユーザビリティのため！！
// フロントでの値チェックはいくらでもすり抜けられるため、必ず、バックエンドでも、バリデーションを行うべきである！！というか、それが新のバリデーションである！！

window.addEventListener("DOMContentLoaded", validate_form);

// validate_form();

function validate_form() {
  const inputs = document.querySelectorAll(".validate-target");
  const form = document.querySelector(".validate-form");

  if (!form) {
    return;
  }

  for (const input of inputs) {
    input.addEventListener("input", (event) => {
      const target = event.currentTarget;
      const feedback = target.nextElementSibling;
      activateSbmitBtn(form);

      if (!feedback.classList.contains("invalid-feedback")) {
        return;
      }

      if (target.checkValidity()) {
        //学習用：validityというプロパティがある！HTMLで指定したバリデーション情報に基づいて、判断してくれる！！！
        target.classList.add("is-valid");
        target.classList.remove("is-invalid");
        feedback.textContent = "";
      } else {
        target.classList.add("is-invalid");
        target.classList.remove("is-valid");

        if (target.validity.valueMissing) {
          feedback.textContent = "値の入力が必須です。";
        } else if (target.validity.tooShort) {
          feedback.textContent = `${target.minLength}以上で入力してください。現在の文字数は、${target.value.length}文字です。`;
        } else if (target.validity.tooLong) {
          feedback.textContent = `${target.maxLength}以下で入力してください。現在の文字数は、${target.value.length}文字です。`;
        } else if (target.validity.patternMismatch) {
          feedback.textContent = "半角英数字で入力してください。";
        }
      }
    });
  }
  activateSbmitBtn(form);
}

function activateSbmitBtn(form) {
  const submitBth = form.querySelector('[type="submit"]');
  if (form.checkValidity()) {
    submitBth.removeAttribute("disabled");
  } else {
    submitBth.setAttribute("disabled", true);
  }
}

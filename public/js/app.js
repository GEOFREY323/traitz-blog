/* =========================================================================
   Traitz Academy — Mini Blog Platform (Project 2)
   Shared vanilla JavaScript for index.html, show.html, and form.html.

   HOW TO USE THIS IN LARAVEL:
   Save as resources/js/blog.js and import it from resources/js/app.js
   (e.g. `import './blog.js';`), or drop the whole contents into app.js.
   None of this depends on jQuery, Vue, or any build step beyond Vite's default.
   ========================================================================= */

document.addEventListener("DOMContentLoaded", () => {
  initNavToggle();
  initDeleteConfirm();
  initTagInput();
  initCharCounter();
});

/* -------------------------------------------------------------------------
   1. Mobile navigation toggle
   ------------------------------------------------------------------------- */
function initNavToggle() {
  const toggle = document.querySelector("[data-nav-toggle]");
  const links = document.querySelector("[data-nav-links]");
  if (!toggle || !links) return;

  toggle.addEventListener("click", () => {
    links.classList.toggle("open");
  });
}

/* -------------------------------------------------------------------------
   2. Confirm before deleting a post
   In Blade, the surrounding <form> will POST with @method('DELETE');
   this just stops that submission unless the user confirms.
   ------------------------------------------------------------------------- */
function initDeleteConfirm() {
  document.querySelectorAll("[data-confirm-delete]").forEach((form) => {
    form.addEventListener("submit", (event) => {
      const message = form.dataset.confirmDelete || "Are you sure?";
      if (!confirm(message)) {
        event.preventDefault();
      }
    });
  });
}

/* -------------------------------------------------------------------------
   3. Tag input widget (used on form.html — the create/edit post form)

   Behaviour:
   - Typing a tag name and pressing Enter or "," adds it as a chip.
   - Each chip has a small "x" button to remove it.
   - A hidden input's value is kept in sync as a comma-separated list,
     which is what actually gets submitted with the form.

   IN BLADE: give the hidden input name="tags" and, in your controller,
   split the comma-separated string on ',' and sync() it to the post's
   tags() relationship — see Module 5 (Eloquent & Database).
   ------------------------------------------------------------------------- */
function initTagInput() {
  const box = document.querySelector("[data-tag-input]");
  if (!box) return;

  const textInput = box.querySelector("input[type='text']");
  const hiddenInput = document.querySelector("[data-tag-hidden]");
  let tags = (hiddenInput.value || "")
    .split(",")
    .map((t) => t.trim())
    .filter(Boolean);

  function render() {
    box.querySelectorAll(".tag-chip").forEach((chip) => chip.remove());

    tags.forEach((tag) => {
      const chip = document.createElement("span");
      chip.className = "tag-chip";
      chip.textContent = tag;

      const removeBtn = document.createElement("button");
      removeBtn.type = "button";
      removeBtn.setAttribute("aria-label", `Remove tag ${tag}`);
      removeBtn.textContent = "×";
      removeBtn.addEventListener("click", () => {
        tags = tags.filter((t) => t !== tag);
        render();
      });

      chip.appendChild(removeBtn);
      box.insertBefore(chip, textInput);
    });

    hiddenInput.value = tags.join(",");
  }

  textInput.addEventListener("keydown", (event) => {
    if (event.key === "Enter" || event.key === ",") {
      event.preventDefault();
      const value = textInput.value.trim().replace(/,$/, "");
      if (value && !tags.includes(value)) {
        tags.push(value);
        render();
      }
      textInput.value = "";
    } else if (event.key === "Backspace" && textInput.value === "" && tags.length) {
      tags.pop();
      render();
    }
  });

  render();
}

/* -------------------------------------------------------------------------
   4. Live character counter for the post body textarea
   ------------------------------------------------------------------------- */
function initCharCounter() {
  const textarea = document.querySelector("[data-char-counter-target]");
  const counter = document.querySelector("[data-char-counter]");
  if (!textarea || !counter) return;

  const max = parseInt(textarea.dataset.charCounterTarget, 10) || 5000;

  function update() {
    const length = textarea.value.length;
    counter.textContent = `${length} / ${max} characters`;
    counter.style.color = length > max ? "#c0392b" : "";
  }

  textarea.addEventListener("input", update);
  update();
}

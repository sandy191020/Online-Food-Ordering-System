const placeholderText = "🔍Search the items here";
let i = 0;
const input = document.getElementById("search-box");

function typePlaceholder() {
  if (i < placeholderText.length) {
    input.setAttribute("placeholder", placeholderText.slice(0, i + 1));
    i++;
    setTimeout(typePlaceholder, 90);
  }
}

window.onload = typePlaceholder;


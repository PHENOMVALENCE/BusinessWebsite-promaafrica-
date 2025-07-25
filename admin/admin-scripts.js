// Admin Panel JavaScript
document.addEventListener("DOMContentLoaded", () => {
  initializeAdmin()
})

function initializeAdmin() {
  setupSidebarToggle()
  setupUserMenu()
  setupFormValidation()
  setupImagePreview()
  setupConfirmDialogs()
}

// Sidebar Toggle for Mobile
function setupSidebarToggle() {
  const sidebarToggle = document.getElementById("sidebarToggle")
  const sidebar = document.querySelector(".sidebar")

  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener("click", () => {
      sidebar.classList.toggle("show")
    })

    // Close sidebar when clicking outside
    document.addEventListener("click", (e) => {
      if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
        sidebar.classList.remove("show")
      }
    })
  }
}

// User Menu Dropdown
function setupUserMenu() {
  const userMenuToggle = document.getElementById("userMenuToggle")
  const userDropdown = document.getElementById("userDropdown")

  if (userMenuToggle && userDropdown) {
    userMenuToggle.addEventListener("click", (e) => {
      e.stopPropagation()
      userDropdown.classList.toggle("show")
    })

    // Close dropdown when clicking outside
    document.addEventListener("click", () => {
      userDropdown.classList.remove("show")
    })
  }
}

// Form Validation
function setupFormValidation() {
  const forms = document.querySelectorAll("form")

  forms.forEach((form) => {
    form.addEventListener("submit", (e) => {
      if (!validateForm(form)) {
        e.preventDefault()
      }
    })
  })
}

function validateForm(form) {
  let isValid = true
  const requiredFields = form.querySelectorAll("[required]")

  requiredFields.forEach((field) => {
    if (!field.value.trim()) {
      showFieldError(field, "This field is required")
      isValid = false
    } else {
      clearFieldError(field)
    }
  })

  // Validate email fields
  const emailFields = form.querySelectorAll('input[type="email"]')
  emailFields.forEach((field) => {
    if (field.value && !isValidEmail(field.value)) {
      showFieldError(field, "Please enter a valid email address")
      isValid = false
    }
  })

  // Validate number fields
  const numberFields = form.querySelectorAll('input[type="number"]')
  numberFields.forEach((field) => {
    if (field.value && isNaN(field.value)) {
      showFieldError(field, "Please enter a valid number")
      isValid = false
    }
  })

  return isValid
}

function showFieldError(field, message) {
  clearFieldError(field)

  const errorDiv = document.createElement("div")
  errorDiv.className = "field-error"
  errorDiv.textContent = message
  errorDiv.style.color = "#dc3545"
  errorDiv.style.fontSize = "0.8rem"
  errorDiv.style.marginTop = "5px"

  field.parentNode.appendChild(errorDiv)
  field.style.borderColor = "#dc3545"
}

function clearFieldError(field) {
  const existingError = field.parentNode.querySelector(".field-error")
  if (existingError) {
    existingError.remove()
  }
  field.style.borderColor = ""
}

function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return emailRegex.test(email)
}

// Image Preview
function setupImagePreview() {
  const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]')

  imageInputs.forEach((input) => {
    input.addEventListener("change", (e) => {
      const files = e.target.files
      const previewContainer = getOrCreatePreviewContainer(input)

      previewContainer.innerHTML = ""

      Array.from(files).forEach((file) => {
        if (file.type.startsWith("image/")) {
          const reader = new FileReader()
          reader.onload = (e) => {
            const img = document.createElement("img")
            img.src = e.target.result
            img.style.width = "100px"
            img.style.height = "100px"
            img.style.objectFit = "cover"
            img.style.borderRadius = "6px"
            img.style.border = "1px solid #dee2e6"
            img.style.margin = "5px"

            previewContainer.appendChild(img)
          }
          reader.readAsDataURL(file)
        }
      })
    })
  })
}

function getOrCreatePreviewContainer(input) {
  let container = input.parentNode.querySelector(".image-preview")

  if (!container) {
    container = document.createElement("div")
    container.className = "image-preview"
    container.style.display = "flex"
    container.style.flexWrap = "wrap"
    container.style.marginTop = "10px"

    input.parentNode.appendChild(container)
  }

  return container
}

// Confirm Dialogs
function setupConfirmDialogs() {
  const deleteLinks = document.querySelectorAll('a[href*="delete"]')

  deleteLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      if (!confirm("Are you sure you want to delete this item? This action cannot be undone.")) {
        e.preventDefault()
      }
    })
  })
}

// Utility Functions
function showNotification(message, type = "info") {
  const notification = document.createElement("div")
  notification.className = `notification notification-${type}`
  notification.textContent = message

  notification.style.position = "fixed"
  notification.style.top = "20px"
  notification.style.right = "20px"
  notification.style.padding = "15px 20px"
  notification.style.borderRadius = "6px"
  notification.style.color = "#fff"
  notification.style.zIndex = "9999"
  notification.style.maxWidth = "300px"
  notification.style.boxShadow = "0 5px 15px rgba(0,0,0,0.2)"

  switch (type) {
    case "success":
      notification.style.backgroundColor = "#28a745"
      break
    case "error":
      notification.style.backgroundColor = "#dc3545"
      break
    case "warning":
      notification.style.backgroundColor = "#ffc107"
      notification.style.color = "#212529"
      break
    default:
      notification.style.backgroundColor = "#17a2b8"
  }

  document.body.appendChild(notification)

  setTimeout(() => {
    notification.remove()
  }, 5000)
}

// Auto-save functionality for forms
function setupAutoSave() {
  const forms = document.querySelectorAll("form[data-autosave]")

  forms.forEach((form) => {
    const formId = form.getAttribute("data-autosave")

    // Load saved data
    loadFormData(form, formId)

    // Save data on input
    form.addEventListener("input", () => {
      saveFormData(form, formId)
    })
  })
}

function saveFormData(form, formId) {
  const formData = new FormData(form)
  const data = {}

  for (const [key, value] of formData.entries()) {
    data[key] = value
  }

  localStorage.setItem(`form_${formId}`, JSON.stringify(data))
}

function loadFormData(form, formId) {
  const savedData = localStorage.getItem(`form_${formId}`)

  if (savedData) {
    const data = JSON.parse(savedData)

    Object.keys(data).forEach((key) => {
      const field = form.querySelector(`[name="${key}"]`)
      if (field && field.type !== "file") {
        field.value = data[key]
      }
    })
  }
}

// Table sorting
function setupTableSorting() {
  const tables = document.querySelectorAll(".data-table")

  tables.forEach((table) => {
    const headers = table.querySelectorAll("th[data-sort]")

    headers.forEach((header) => {
      header.style.cursor = "pointer"
      header.addEventListener("click", () => {
        sortTable(table, header.getAttribute("data-sort"))
      })
    })
  })
}

function sortTable(table, column) {
  const tbody = table.querySelector("tbody")
  const rows = Array.from(tbody.querySelectorAll("tr"))

  const sortedRows = rows.sort((a, b) => {
    const aValue = a.querySelector(`td[data-${column}]`)?.textContent || ""
    const bValue = b.querySelector(`td[data-${column}]`)?.textContent || ""

    return aValue.localeCompare(bValue)
  })

  tbody.innerHTML = ""
  sortedRows.forEach((row) => tbody.appendChild(row))
}

// Search functionality
function setupSearch() {
  const searchInputs = document.querySelectorAll("input[data-search]")

  searchInputs.forEach((input) => {
    const targetSelector = input.getAttribute("data-search")
    const targets = document.querySelectorAll(targetSelector)

    input.addEventListener("input", () => {
      const searchTerm = input.value.toLowerCase()

      targets.forEach((target) => {
        const text = target.textContent.toLowerCase()
        target.style.display = text.includes(searchTerm) ? "" : "none"
      })
    })
  })
}

// Initialize additional features
document.addEventListener("DOMContentLoaded", () => {
  setupAutoSave()
  setupTableSorting()
  setupSearch()
})

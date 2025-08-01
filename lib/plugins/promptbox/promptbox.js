function copyPrompt(id) {
    const container = document.querySelector(`.promptbox-plugin-container[data-id="${id}"]`);
    const promptText = container.querySelector(".promptbox-plugin-text").innerText;
    navigator.clipboard.writeText(promptText).then(() => {
        showCopyIndicator(id, "Prompt copied!");
    }).catch(err => {
        console.error("Failed to copy: ", err);
    });
}

function copyURL(id) {
    const container = document.querySelector(`.promptbox-plugin-container[data-id="${id}"]`);
    const pageURL = window.location.href;
    navigator.clipboard.writeText(pageURL).then(() => {
        showCopyIndicator(id, "URL copied!");
    }).catch(err => {
        console.error("Failed to copy URL: ", err);
    });
}

function showCopyIndicator(id, message) {
    const indicator = document.querySelector(`.promptbox-plugin-container[data-id="${id}"] .promptbox-plugin-copy-indicator`);
    indicator.innerText = message;
    indicator.style.display = "block";
    setTimeout(() => {
        indicator.style.display = "none";
    }, 2000);
}

// Add event listeners for editable brackets
document.addEventListener('DOMContentLoaded', function() {
    // Find all bracketed text elements
    const bracketedElements = document.querySelectorAll('.promptbox-plugin-text .bracket');
    
    // Add click event listener to each bracketed element
    bracketedElements.forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent event bubbling
            openEditPopup(this);
        });
    });
});

// Global variable to track active popup
let activePopup = null;

function openEditPopup(element) {
    // Close any existing popup
    if (activePopup && activePopup.parentNode) {
        document.body.removeChild(activePopup);
    }
    
    // Create popup container
    const popup = document.createElement('div');
    popup.className = 'promptbox-edit-popup';
    activePopup = popup;  // Store reference to active popup
    
    // Get current text (remove brackets)
    const currentText = element.textContent.replace(/[\[\]]/g, '');
    const isSystem = element.classList.contains('system');
    const systemName = element.dataset.system;
    
    let popupContent = '';
    
    // Check if we should show dropdown or input
    const showDropdown = isSystem && 
                        window.promptboxSystemData && 
                        window.promptboxSystemData[systemName] && 
                        window.promptboxSystemData[systemName].length > 0;
    
    if (showDropdown) {
        // Create dropdown for system selection
        popupContent = `
            <div class="promptbox-edit-popup-content">
                <h3>${window.promptboxLang.select_system.replace('%s', systemName)}</h3>
                <select class="promptbox-edit-select">
                    ${window.promptboxSystemData[systemName].map(option => 
                        `<option value="${option}" ${option === currentText ? 'selected' : ''}>${option}</option>`
                    ).join('')}
                </select>
                <div class="promptbox-edit-buttons">
                    <button class="promptbox-edit-save">${window.promptboxLang.save}</button>
                    <button class="promptbox-edit-cancel">${window.promptboxLang.cancel}</button>
                </div>
            </div>
        `;
    } else {
        // Create input for regular text
        popupContent = `
            <div class="promptbox-edit-popup-content">
                <h3>${window.promptboxLang.edit_text}</h3>
                <input type="text" class="promptbox-edit-input" value="${currentText}">
                <div class="promptbox-edit-buttons">
                    <button class="promptbox-edit-save">${window.promptboxLang.save}</button>
                    <button class="promptbox-edit-cancel">${window.promptboxLang.cancel}</button>
                </div>
            </div>
        `;
    }
    
    // Add popup to document
    popup.innerHTML = popupContent;
    document.body.appendChild(popup);
    
    // Get input/select element
    const input = popup.querySelector(showDropdown ? '.promptbox-edit-select' : '.promptbox-edit-input');
    input.focus();
    if (!showDropdown) input.select();
    
    // Function to close popup
    const closePopup = () => {
        if (popup && popup.parentNode) {
            document.body.removeChild(popup);
            activePopup = null;  // Clear active popup reference
        }
    };
    
    // Add event listeners for buttons
    popup.querySelector('.promptbox-edit-save').addEventListener('click', function() {
        try {
            const newText = input.value.trim();
            if (newText) {
                if (showDropdown) {
                    // If we showed dropdown, save without @ symbol
                    element.textContent = `[${newText}]`;
                    element.dataset.system = systemName;
                    element.classList.add('system');
                } else {
                    // If we showed input, convert to regular text
                    element.textContent = `[${newText}]`;
                    element.classList.remove('system');
                    delete element.dataset.system;
                }
            }
        } catch (e) {
            console.error('Error saving text:', e);
        } finally {
            closePopup();
        }
    });
    
    popup.querySelector('.promptbox-edit-cancel').addEventListener('click', closePopup);
    
    // Close popup when clicking outside
    popup.addEventListener('click', function(e) {
        if (e.target === popup) {
            closePopup();
        }
    });
    
    // Handle Enter key
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            try {
                const newText = input.value.trim();
                if (newText) {
                    if (showDropdown) {
                        element.textContent = `[${newText}]`;
                        element.dataset.system = systemName;
                        element.classList.add('system');
                    } else {
                        element.textContent = `[${newText}]`;
                        element.classList.remove('system');
                        delete element.dataset.system;
                    }
                }
            } catch (e) {
                console.error('Error saving text:', e);
            } finally {
                closePopup();
            }
        } else if (e.key === 'Escape') {
            closePopup();
        }
    });
}

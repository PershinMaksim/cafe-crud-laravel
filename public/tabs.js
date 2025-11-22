function openTab(tabName) {
    // Hide all tab contents
    const tabContents = document.getElementsByClassName('tab-content');
    for (let i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.remove('active');
    }

    // Remove active class from all tab buttons
    const tabButtons = document.getElementsByClassName('tab-button');
    for (let i = 0; i < tabButtons.length; i++) {
        tabButtons[i].classList.remove('active');
    }

    // Show the specific tab content and mark button as active
    document.getElementById(tabName).classList.add('active');
    
    // Find and activate the corresponding button
    for (let i = 0; i < tabButtons.length; i++) {
        if (tabButtons[i].textContent.toLowerCase().includes(tabName)) {
            tabButtons[i].classList.add('active');
        }
    }
}
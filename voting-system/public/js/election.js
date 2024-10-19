document.addEventListener("DOMContentLoaded", function () {
    // Handle Add Election Modal Opening and Closing
    const addElectionModal = document.getElementById('addElectionModal');
    const openAddElectionModal = document.getElementById('openAddElectionModal');
    const closeAddElectionModal = document.getElementById('closeAddElectionModal');

    openAddElectionModal.onclick = () => {
        addElectionModal.style.display = 'block';
    };

    closeAddElectionModal.onclick = () => {
        addElectionModal.style.display = 'none';
    };

    window.onclick = function (event) {
        if (event.target === addElectionModal) {
            addElectionModal.style.display = 'none';
        }
    };

    // Elements for Election Type and Restrictions
    const electionTypeSelect = document.getElementById('election_type');
    const restrictionDropdown = document.getElementById('restrictionDropdown');

    const faculties = ['FaCET', 'FALS', 'FBM', 'FNAHS', 'FTED', 'FCGE'];
    const programs = ['BSIT', 'BSCE', 'BSITM', 'BSBIO', 'BSES', 'BSA', 'BSBA', 'BSHM', 'BSN', 'BEED', 'BSED', 'BSC'];

    function handleElectionTypeChange(type, restrictionElementId = 'restriction', restrictionValue = '') {
        const restrictionSelect = document.getElementById(restrictionElementId);
        restrictionSelect.innerHTML = ''; // Clear existing options

        if (type === 'Faculty') {
            restrictionDropdown.style.display = 'block';
            faculties.forEach(faculty => {
                const option = document.createElement('option');
                option.value = faculty;
                option.textContent = faculty;
                if (faculty === restrictionValue) {
                    option.selected = true; // Pre-select the restriction if editing
                }
                restrictionSelect.appendChild(option);
            });
        } else if (type === 'Program') {
            restrictionDropdown.style.display = 'block';
            programs.forEach(program => {
                const option = document.createElement('option');
                option.value = program;
                option.textContent = program;
                if (program === restrictionValue) {
                    option.selected = true; // Pre-select the restriction if editing
                }
                restrictionSelect.appendChild(option);
            });
        } else if (type === 'General') {
            restrictionDropdown.style.display = 'block';
            const option = document.createElement('option');
            option.value = 'None';
            option.textContent = 'None';
            option.selected = restrictionValue === 'None'; // Pre-select None for General
            restrictionSelect.appendChild(option);
        } else {
            restrictionDropdown.style.display = 'none'; // Hide if not applicable
        }
    }

    document.getElementById('election_type').addEventListener('change', function () {
        handleElectionTypeChange(this.value);
    });
    // Show or hide the restriction dropdown based on election type
    electionTypeSelect.addEventListener('change', function () {
        handleElectionTypeChange(this.value);
    });
    


    // Get current date and time
    const currentDate = new Date();

    // Initialize Flatpickr for the start date with restriction (No past dates allowed)
    const startDatePicker = flatpickr("#start_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: currentDate, // Prevent selecting past dates for start date
        onChange: function(selectedDates) {
            const startDate = selectedDates[0];
            endDatePicker.set('minDate', startDate); // Set minimum date for end date
        }
    });

    const endDatePicker = flatpickr("#end_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: currentDate,
    });

    // Add Election Form Submission
    document.getElementById("addElectionForm").onsubmit = function (e) {
        e.preventDefault();

        const startDate = startDatePicker.input.value;
        const endDate = endDatePicker.input.value;

        if (!startDate || !endDate) {
            alert('Please select both start and end dates.');
            return;
        }

        const formData = new FormData(this);
        formData.set('start_date', startDate);
        formData.set('end_date', endDate);

        fetch('/elections', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Election added successfully!");
                addElectionModal.style.display = "none";
                location.reload();
            } else {
                alert("Error adding election: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred. Please try again.");
        });
    };

    // Handle Edit Election Modal
    const editElectionModal = document.getElementById('editElectionModal');
    const closeEditElectionModal = document.getElementById('closeEditElectionModal');

    // Initialize Flatpickr for the edit modal
    function initEditModal() {
        flatpickr("#edit_start_date", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        flatpickr("#edit_end_date", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    }

    // Function to open edit modal
    function openEditElectionModal(election) {
        // Populate the form with election data
        document.getElementById('edit_election_name').value = election.election_name;
        document.getElementById('edit_description').value = election.description;
        document.getElementById('edit_election_type').value = election.election_type;
    
        // Populate restrictions based on the election type
        handleElectionTypeChange(election.election_type, 'edit_restriction', election.restriction);
    
        // Set start and end dates
        document.getElementById('edit_start_date').value = election.start_date;
        document.getElementById('edit_end_date').value = election.end_date;
    
        // Initialize Flatpickr for the new dates
        initEditModal();
    
        // Open modal
        editElectionModal.style.display = 'block';
    }


    // Close modal
    closeEditElectionModal.onclick = () => {
        editElectionModal.style.display = 'none';
    };

    // Close modal when clicking outside of it
    window.onclick = (event) => {
        if (event.target === editElectionModal) {
            editElectionModal.style.display = 'none';
        }
    };

    // Assuming you have a button to trigger the edit modal for each election
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.onclick = function () {
            const election = JSON.parse(button.getAttribute('data-election')); // Replace with actual data retrieval method
            openEditElectionModal(election);
        };
    });

    // Handle Edit Election Form Submission
    document.getElementById("editElectionForm").onsubmit = function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const electionId = this.getAttribute('data-election-id'); // Assuming you set this when opening the modal

        fetch(`/elections/${electionId}`, {
            method: 'PUT', // Use PUT for updating
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Election updated successfully!");
                editElectionModal.style.display = "none";
                location.reload(); // Refresh to see changes
            } else {
                alert("Error updating election: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred. Please try again.");
        });
    };
    // Handle restrictions in the edit modal when election type changes
    document.getElementById('edit_election_type').addEventListener('change', function () {
        handleElectionTypeChange(this.value, 'edit_restriction');
    });
});

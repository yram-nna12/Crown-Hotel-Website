const today = new Date();
    const minCheckin = new Date(today.setDate(today.getDate() + 2));
    flatpickr("#checkin", {
      minDate: minCheckin,
      dateFormat: "Y-m-d",
      onChange: function(selectedDates, dateStr) {
        checkout.set("minDate", dateStr);
      }
    });

    const checkout = flatpickr("#checkout", {
      dateFormat: "Y-m-d",
      minDate: minCheckin
    });
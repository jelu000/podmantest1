// src/components/DeadlinePicker.js (ny komponent)
import React, { useState } from 'react';
import { DayPicker } from 'react-day-picker';
import { format } from 'date-fns'; // Importera format från date-fns för snyggare utdata
//import 'react-day-picker/dist/style.css'; // Glöm inte att importera CSS!
//import './DeadLinePicker.css';

function DeadlinePicker({onValtDatum}) {
  const [selectedDay, setSelectedDay] = useState();

  // Anpassad funktion för att hantera val
  const handleDaySelect = (day) => {
    setSelectedDay(day); // Uppdaterar kalenderns inre state
    
    if (day) {
      // Formatera datumet till en sträng (t.ex. "2025-11-20")
      // Använd det format du vill ha i textfältet
      const formattedDate = format(day, 'yyyy-MM-dd'); 
      
      // SKICKA DET FORMATTERADE DATUMET UPP TILL FÖRÄLDERN!
      onValtDatum(formattedDate); 
    } else {
      // Rensa textfältet om användaren avmarkerar ett datum
      onValtDatum('');
    }
  };

  return (
    <div>
      <h4 className='h4'>En Kalender</h4>
      <DayPicker
        mode="single" // Tillåter endast val av ett datum
        selected={selectedDay}
        onSelect={handleDaySelect}
        // Lägg till andra props som t.ex. disabled (för att inte tillåta gamla datum)
      />
      {selectedDay && <p>Vald deadline: {selectedDay.toLocaleDateString()}</p>}

    </div>
  );
}

export default DeadlinePicker;
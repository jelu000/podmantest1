//import React, { useState, useEffect } from 'react'
import React, { useState, useEffect, useCallback } from 'react';
import ListTodos from './ListTodos';
import AddTodo from './AddTodo';
import TodoApi, { addTodos, fetchTodos, deleteTodo } from './TodoApi';

import './App.css';

function App() {

 
  const [tasks, setTasks] = useState([]);
  const [isLoading, setIsLoading] = useState(true);

  // 1. ANVÄND useCallback för att skapa en stabil hämtningsfunktion
  const loadTasks = useCallback(async () => {
      setIsLoading(true);
      try {
          // Gör anropet till din API-modul
          const data = await fetchTodos(); // Await löser Promise till data
          setTasks(data); 
      } catch (error) {
          console.error("Kunde inte hämta uppgifter:", error);
      } finally {
          setIsLoading(false); 
      }
  }, []); // [] gör att funktionen bara skapas en gång

  // 2. ANVÄND useEffect för att trigga funktionen vid sidladdning
  useEffect(() => {
    // Kör hämtningsfunktionen
    loadTasks(); 
    
    // Den tomma arrayen [] gör att denna effekt endast körs efter FÖRSTA renderingen
  }, [loadTasks]); // loadTasks är en dependency men tack vare useCallback är den stabil

  // Om du vill hantera radering/lägg till här, definiera funktionerna:
  const handleDelete = (id) => { 
    /* ... anropa deleteTodo och uppdatera tasks ... */ 
  
  };
  
  // Hantera laddningsstatus
  if (isLoading) {
    return <div>Laddar uppgifter...</div>;
  }
    
      // Gör anropet till din API-modul
      //const data = fetchTodos();
      //console.log(data);
      
      
      //setTasks(data); // Spara den hämtade datan i state
       addTodos("2334")

  return (
    <div className="App">
      <header className="App-header">
        <h3>To Do</h3>
        {/* Skicka ner loadTasks så att AddTodo kan be App.js ladda om listan */}
        <AddTodo onNewTodoAdded={loadTasks} /> 
        
        {/* Skicka den hämtade listan till ListTodos */}
        <ListTodos tasks={tasks} />

      </header>
    </div>
  );
}

export default App;

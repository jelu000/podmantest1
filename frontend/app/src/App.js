import React, { useState, useEffect } from 'react'
import ListTodos from './ListTodos';
import AddTodo from './AddTodo';
import TodoApi, { fetchTodos } from './TodoApi';

import './App.css';

function App() {

  //1. STATE för att lagra listan med uppgifter
  const [tasks, setTasks] = useState([]);
    
  // 2. STATE för att hantera laddningsstatus
  const [isLoading, setIsLoading] = useState(true);

  // Funktion för att hämta data
    // const loadTasks = async () => {
    //     setIsLoading(true);
    //     try {
            
    //         const data = await fetchTodos();
    //         setTasks(data); 
    //     } catch (error) {
    //         console.error("Kunde inte hämta uppgifter:", error);
            
    //     } finally {
    //         setIsLoading(false); 
    //     }

        
    // };
    
      // Gör anropet till din API-modul
      const data = fetchTodos();
      //setTasks(data); // Spara den hämtade datan i state

  return (
    <div className="App">
      <header className="App-header">
        <h3>To Do</h3>
        <AddTodo />
        <ListTodos />

      </header>
    </div>
  );
}

export default App;

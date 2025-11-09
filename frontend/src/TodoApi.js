import axios from 'axios';

// Hämta API-URL från miljövariablerna
const API_URL = process.env.REACT_APP_API_URL || 'http://localhost:8080/api.php';

// Gå till http://localhost:8080/api.php?action=markCompleted&id=5
// const taskId = 5;
// const apiUrl = `http://localhost:8080/api.php?action=markCompleted&id=${taskId}`;

// Exportfunktion för att Hämta alla uppgifter (READ)
export const fetchTodos = async () => {
    try {
        //console.log("Hej")
        let req = `${API_URL}?action=getTodos`;
        const response = await axios.get(req);

        //return response.data.data; // Returnera listan med uppgifter
        let helasvaret = response.data;
        //console.log(`helasvaret = ${helasvaret.success}`)
        
        if (helasvaret.success && Array.isArray(helasvaret.data)){
            return helasvaret.data;    
        }
        else
            return []
        
    } catch (error) {
        console.error("Fel vid hämtning av uppgifter:", error);
        throw error; // Kasta felet så att komponenten kan hantera det
    }
};

// Exportfunktion för att Hämta alla uppgifter (READ)
export const addTodos = async (todotext) => {
    try {
        //console.log("Hej")
        let req = `${API_URL}?action=addTodo`;
        const response = await axios.post( req, { todotext } );// Skickar datakroppen som JSON
        return response.data; // Returnera listan med uppgifter
    } catch (error) {
        console.error("Fel vid hämtning av uppgifter:", error);
        throw error; // Kasta felet så att komponenten kan hantera det
    }
};


// Exportfunktion för att Radera en uppgift (DELETE)
export const deleteTodo = async (id) => {
    try {
        
        // Skicka DELETE-förfrågan (med ID i URL-parametern)
        const response = await axios.delete(`${API_URL}?id=${id}&action=deleteTodo`);
        // Returnera ingenting, eller true, vid lyckad operation
        return true; 
    } catch (error) {
        console.error(`Fel vid radering av uppgift med ID ${id}:`, error);
        throw error;
    }
};


import axios from 'axios';

// Hämta API-URL från miljövariablerna
const API_URL = process.env.REACT_APP_API_URL || 'http://localhost:8080/api.php';

// Exportfunktion för att Hämta alla uppgifter (READ)
export const fetchTodos = async () => {
    try {
        const response = await axios.get(API_URL);
        return response.data; // Returnera listan med uppgifter
    } catch (error) {
        console.error("Fel vid hämtning av uppgifter:", error);
        throw error; // Kasta felet så att komponenten kan hantera det
    }
};

// Exportfunktion för att Lägga till en ny uppgift (CREATE)
export const addTodo = async (title) => {
    try {
        const response = await axios.post(
            API_URL, 
            { title } // Skickar datakroppen som JSON
        );
        return response.data; // Returnera den skapade uppgiften
    } catch (error) {
        console.error("Fel vid skapande av uppgift:", error);
        throw error;
    }
};

// Exportfunktion för att Radera en uppgift (DELETE)
export const deleteTodo = async (id) => {
    try {
        // Skicka DELETE-förfrågan (med ID i URL-parametern)
        await axios.delete(`${API_URL}?id=${id}`);
        // Returnera ingenting, eller true, vid lyckad operation
        return true; 
    } catch (error) {
        console.error(`Fel vid radering av uppgift med ID ${id}:`, error);
        throw error;
    }
};

// ... här kan du lägga till fler funktioner, t.ex. updateTodo ...
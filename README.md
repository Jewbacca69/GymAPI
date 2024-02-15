# Gym Reservation API Documentation

The Gym Reservation API allows users to manage reservations at various gyms. Users can view available gyms, make reservations, retrieve details of existing reservations, and delete reservations.

## Base URL

The base URL for accessing the API is: `http://localhost/api`

## Authentication

Authentication is not required to access the API endpoints.

## Gym Endpoints

### Retrieve All Gyms

- **URL:** `/gyms`
- **Method:** GET
- **Description:** Retrieves a list of all available gyms.
- **Response:**
    - Status Code: 200 (OK)
    - Content: Array of Gym objects

### Retrieve a Specific Gym

- **URL:** `/gyms/{gymId}`
- **Method:** GET
- **Description:** Retrieves details of a specific gym by its ID.
- **Parameters:**
    - `gymId`: The unique identifier of the gym.
- **Response:**
    - Status Code: 200 (OK)
    - Content: Gym object

## Reservation Endpoints

### Retrieve Reservations for a Gym

- **URL:** `/gyms/{gymId}/reservations`
- **Method:** GET
- **Description:** Retrieves all reservations for a specific gym.
- **Parameters:**
    - `gymId`: The unique identifier of the gym.
- **Response:**
    - Status Code: 200 (OK)
    - Content: Array of Reservation objects

### Create a Reservation

- **URL:** `/gyms/{gymId}/reservations`
- **Method:** POST
- **Description:** Creates a new reservation for the specified gym.
- **Parameters:**
    - `gymId`: The unique identifier of the gym.
- **Request Body:**
    - `user_id`: The ID of the user making the reservation.
    - `reservation_time`: The date and time of the reservation (format: YYYY-MM-DD HH:MM:SS).
- **Response:**
    - Status Code: 201 (Created)
    - Content: Reservation object

### Retrieve a Specific Reservation

- **URL:** `/gyms/{gymId}/reservations/{reservationId}`
- **Method:** GET
- **Description:** Retrieves details of a specific reservation at the specified gym.
- **Parameters:**
    - `gymId`: The unique identifier of the gym.
    - `reservationId`: The unique identifier of the reservation.
- **Response:**
    - Status Code: 200 (OK)
    - Content: Reservation object

### Delete a Reservation

- **URL:** `/gyms/{gymId}/reservations/{reservationId}`
- **Method:** DELETE
- **Description:** Deletes a specific reservation from the specified gym.
- **Parameters:**
    - `gymId`: The unique identifier of the gym.
    - `reservationId`: The unique identifier of the reservation.
- **Response:**
    - Status Code: 204 (No Content)
    - Content: Success message

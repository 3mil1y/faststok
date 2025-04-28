# FastStok - warehouse Management System

**FastStok** is a web-based inventory and warehouse management system developed in PHP. It is designed to help businesses effectively track products, manage stock levels, handle internal and external transfers, and generate detailed reports.

** Currently in mvp version **

---

## Features

### Product Management
- Create, edit, and delete products
- Track stock quantities and availability
- Assign products to specific fisic locations (sector, floor, position)
- Search and filter product listings
- Handle stock reduction on transfers or usage

### User Management
- Secure login system with session-based authentication
- Role-based access control (admin, operator, etc.)
- Create, edit, and manage user accounts
- Profile editing and user role assignment

### Transfer Management
- Internal transfers between storage locations
- External (outbound) transfers
- Detailed transfer history for auditing and tracking

### Reporting
- Real-time stock level reports
- Expiry date monitoring
- Customizable report generation

### Location Management
- Organize inventory by hierarchical location structure (sector > floor > position)
- Track product movement between locations
- Visual mapping for better stock control

## Project Structure

app/
├── components/           # Reusable UI components 
│   ├── Layout/          # Layout components (Header, Head) 
│   ├── Form/            # Form components and handlers 
│   ├── Lists/           # List view components 
│   ├── Report/          # Report generation components 
│   ├── Message/         # User notification system 
│   └── Common/          # Shared components (LoadingSpinner, Popup) 
├── controllers/         # Application controllers 
├── core/               # Core "framework" files 
│   ├── DbConnect/      # Database connection handling 
│   └── Middleware/     # Authentication & authorization 
├── entities/           # Business logic entities 
├── models/             # Data access layer 
├── views/              # View templates 
└── public/             # Public assets and entry point 
    └── css/            # Stylesheets 

## Technical Stack

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, Tailwind CSS
- **Architecture**: MVC Pattern

## Core Components

### Models
- `ProductModel`: Handles product-related database operations
- `UserModel`: Manages user data and authentication
- `LocationModel`: Controls location management

### Controllers
- `AdminController`: Administrative functions
- `ProductController`: Product management
- `ReportController`: Report generation
- `TransferController`: Transfer operations
- `UserController`: User management
- `ValidationController`: Input validation

### Middleware
- `AuthMiddleware`: Authentication checks
- `RoleMiddleware`: Role-based access control

## Setup Instructions

1. Clone the repository to your local AMP area (e.g., Laragon `www`, XAMPP `htdocs`, etc.)
2. Import the database schema
3. Configure database connection in .env archive
4. Ensure proper permissions are set for file operations
5. Access the application through your web browser

## Security Features

- Session-based authentication
- Password hashing
- Role-based access control
- Input validation and sanitization
- XSS protection

## Frontend Features

- Responsive design using Tailwind CSS
- Interactive loading indicators
- Toast notifications system
- Modal popups for confirmations
- Form validation feedback

## Best Practices

- MVC architecture for clean code separation
- Component-based UI structure
- Centralized database connection handling
- Consistent error handling
- Modular and reusable code

## Contributing

When contributing to this project, please:

1. Follow the existing code style
2. Write clear commit messages
3. Document any new features
4. Test your changes thoroughly
5. Submit pull requests for review

## Contact

**Emilly Waiandt**  
GitHub: [github.com/3mil1y](https://github.com/3mil1y)  
Email: emillywaiandt@gmail.com 
LinkedIn: [linkedin.com/in/emilly-waiandt](https://www.linkedin.com/in/emilly-waiandt)

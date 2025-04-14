# FastStok - Inventory Management System

FastStok is a web-based inventory management system built with PHP that helps businesses track their products, manage stock levels, handle transfers, and generate reports.

## Features

- **Product Management**
  - Create and edit products
  - Track product quantities
  - Manage product locations
  - Search products
  - Decrease product quantities

- **User Management**
  - User authentication and authorization
  - Role-based access control
  - Create and manage user accounts
  - Edit user profiles

- **Transfer Management**
  - Internal transfers between locations
  - External transfers (outbound)
  - Transfer history tracking

- **Reporting**
  - Stock level reports
  - Expiry date tracking
  - Custom report generation

- **Location Management**
  - Organize products by sectors, floors, and positions
  - Track product movements between locations

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

1. Clone the repository to your XAMPP htdocs directory
2. Import the database schema (if provided)
3. Configure database connection in `app/core/DatabaseConfig.php`
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

## License

[Add appropriate license information]

## Contact

[Add contact information for project maintainers]
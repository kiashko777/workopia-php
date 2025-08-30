# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

### Development Server
```bash
# Start PHP development server
php -S localhost:8000 -t public
```

### Dependencies
```bash
# Install dependencies
composer install

# Update autoloader when adding new classes
composer dump-autoload
```

### Database Setup
```bash
# Create database named 'workopia' in MySQL
# Import the SQL schema from README.md (tables: users, listings)
```

## Architecture

### MVC Structure
The application follows a custom MVC pattern with two main namespaces:

- **Framework/** - Core framework classes providing infrastructure
  - `Router.php` - Handles routing with middleware support, route parameters
  - `Database.php` - PDO wrapper for database operations, prepared statements
  - `Session.php` - Session management, flash messages
  - `Validation.php` - Input validation rules
  - `Authorization.php` - User authorization checks
  - `middleware/Authorize.php` - Route middleware for auth/guest protection

- **App/** - Application-specific code
  - `controllers/` - Controller classes handling HTTP requests
  - `views/` - PHP view templates with partials support

### Request Flow
1. `public/index.php` - Entry point, initializes autoloader and session
2. `routes.php` - Defines all application routes with middleware
3. Router matches URI to controller@method
4. Middleware checks (auth/guest) execute before controller
5. Controller processes request, interacts with Database
6. View renders with data extracted to local scope

### Key Patterns

**Routing with Parameters:**
- Routes support parameters: `/listings/{id}`
- Parameters passed to controller methods as arguments
- Middleware array: `['auth']` or `['guest']`

**Database Interactions:**
- All queries use PDO prepared statements via Database class
- Controllers instantiate Database and call query/fetch methods
- No ORM - direct SQL queries

**Authentication Flow:**
- UserController handles registration/login/logout
- Sessions store user data after authentication
- Authorization class checks ownership for resource access
- Middleware protects routes requiring authentication

**View System:**
- Views loaded via `loadView()` helper with data array
- Partials loaded via `loadPartial()` for reusable components
- Data extracted to view scope before inclusion

## AI Team Configuration

**Important: YOU MUST USE subagents when available for the task.**

### Detected Technology Stack:
- **Backend Framework**: Vanilla PHP 8.0+ with custom MVC framework
- **Database**: MySQL with PDO
- **Architecture**: Custom lightweight MVC pattern
- **Routing**: Custom router with middleware support
- **Authentication**: Session-based with custom Authorization class
- **Frontend**: HTML/CSS (no modern framework detected)
- **Dependency Management**: Composer (minimal dependencies)
- **Build Tools**: None detected (vanilla PHP deployment)

### AI Team Assignments:

| Task | Agent | Notes |
|------|-------|-------|
| Backend development & PHP features | `backend-developer` | Primary agent for PHP logic, controllers, models, database operations |
| API design & REST endpoints | `api-architect` | Design RESTful APIs, OpenAPI specs for job listings and user management |
| Code quality & security reviews | `code-reviewer` | Required for all PRs - security-aware review of PHP code, SQL injection prevention |
| Performance optimization | `performance-optimizer` | Database query optimization, caching strategies, PHP performance tuning |
| Frontend UI development | `frontend-developer` | HTML/CSS improvements, progressive enhancement, responsive design |
| Documentation updates | `documentation-specialist` | API documentation, installation guides, architecture documentation |

### Project-Specific Context:
- **Core Entities**: Users, Job Listings
- **Key Features**: User authentication, CRUD operations for job listings, search functionality
- **Security Focus**: SQL injection prevention, session management, input validation
- **Performance Priorities**: Database query optimization, search functionality
- **Architecture Pattern**: Custom lightweight MVC with separation of concerns

### Usage Examples:
- `@backend-developer add pagination to the job listings endpoint`
- `@api-architect design a REST API specification for the job search feature`
- `@code-reviewer review the ListingController for security vulnerabilities`
- `@performance-optimizer optimize the database queries in the search functionality`

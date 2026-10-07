# WP Client Toolkit

Give your clients a focused WordPress dashboard while keeping full control over what they can see and change.

WP Client Toolkit lets an administrator mark any user as a **Client**. Clients get a simplified admin menu, a friendly welcome dashboard, and permissions you control at two levels: which features they can reach, and which actions (view, add, edit, delete) they can perform inside each one.

## Features

- **Two user modes.** Every user is either a *Developer* (normal WordPress experience) or a *Client* (restricted experience).
- **Feature-level access.** Enable or disable Posts, Pages, Media and Comments, either as a site-wide default or per client.
- **Action-level permissions.** For each client and feature, choose exactly which of *View / Manage*, *Add New / Upload*, *Edit* and *Delete* are allowed.
- **Clean client dashboard.** Default dashboard widgets are removed and replaced with a welcome panel that shows only the sections the client can use.
- **Layered enforcement.** Restrictions apply through hidden menus, redirects on direct URLs, and WordPress capability checks, so hiding a menu item is not the only protection.
- **Self-lockout protection.** The administrator currently logged in can never be switched to Client mode.
- **Hidden for clients, always.** Plugins, Themes, Tools, Settings and Users menus are removed for clients.
- **Clean uninstall.** All options and user meta are removed when the plugin is deleted.

## Requirements

- WordPress 5.8 or later
- PHP 7.4 or later

## Installation

**From a release zip**

1. Download the latest zip from the [Releases](../../releases) page.
2. In WordPress, go to **Plugins → Add New → Upload Plugin** and upload the zip.
3. Activate **WP Client Toolkit**.

**From source**

```bash
cd wp-content/plugins
git clone https://github.com/hasnatahmad095/client-toolkit.git wp-client-toolkit
```

Then activate the plugin from the **Plugins** screen.

## Usage

Open **Client Toolkit** in the admin menu (requires the `manage_options` capability). The screen has four tabs:

| Tab | What it does |
| --- | --- |
| **Users & Modes** | Switch each account between Developer and Client. |
| **Default Access** | Set the feature-level access that clients inherit unless customized. |
| **Client Access** | Override feature access for a specific client. |
| **Action Permissions** | Choose the exact actions each client may perform in Posts, Pages, Media and Comments. |

Typical setup:

1. Create the client's user account in WordPress.
2. In **Users & Modes**, set that account to **Client**.
3. Adjust **Default Access**, then override per client in **Client Access** if needed.
4. Fine-tune **Action Permissions** (for example, allow editing pages but not deleting them).

Sections a client cannot access are removed from their menu and from their welcome dashboard, and direct URLs redirect them back to the dashboard.

## How permissions work

Access is checked in two layers, and **both** must allow an action:

1. **Feature layer** – is the feature (`posts`, `pages`, `media`, `comments`) enabled for this client?
2. **Action layer** – is the specific action (`view`, `add`, `edit`, `delete`) enabled for this client within that feature?

A client with no custom settings inherits the default feature access and all actions. Comments have no *Add* action.

## Project structure

```
wp-client-toolkit/
├── wp-client-toolkit.php          Plugin header, constants and component loader
├── uninstall.php                  Removes plugin data on uninstall
├── includes/                      Core logic (runs on every request)
│   ├── helpers.php                Permission definitions, user mode and permission lookups
│   ├── menu-restrictions.php      Hides admin menu items from clients
│   ├── url-restrictions.php       Redirects clients away from disabled features
│   ├── action-restrictions.php    Redirects clients away from disabled actions
│   ├── capabilities.php           Enforces permissions via the map_meta_cap filter
│   ├── comments.php               Removes comment trash/delete actions when not allowed
│   └── client-dashboard.php       Removes default widgets and adds the welcome panel
├── admin/                         Settings screen (loaded in wp-admin only)
│   ├── menu.php                   Registers the "Client Toolkit" menu page
│   ├── settings-page.php          Settings page controller
│   ├── settings-save.php          Form handlers with nonce checks and sanitization
│   ├── assets.php                 Enqueues admin and dashboard styles and scripts
│   └── views/                     Template partials, one per section of the page
│       ├── header.php
│       ├── tabs.php
│       ├── panel-users.php
│       ├── panel-defaults.php
│       ├── panel-clients.php
│       ├── panel-actions.php
│       └── security-notice.php
└── assets/
    ├── css/
    │   ├── admin.css              Settings screen styles
    │   └── client-dashboard.css   Client welcome dashboard styles
    └── js/
        └── admin.js               Tab switching and toggle interactions
```

## Data storage

| Key | Type | Purpose |
| --- | --- | --- |
| `wpct_client_permissions` | option | Default feature access for clients |
| `wpct_user_mode` | user meta | `developer` or `client` |
| `wpct_user_permissions` | user meta | Per-client feature access override |
| `wpct_user_granular_permissions` | user meta | Per-client action permissions |

## Extending

The plugin is procedural and uses a `wpct_` prefix. Useful entry points:

- `wpct_get_permissions()` – feature definitions (label, description, icon)
- `wpct_get_granular_permissions()` – actions available per feature
- `wpct_is_client( $user_id )` – is the user in Client mode?
- `wpct_user_has_permission( $user_id, $feature )` – feature-level check
- `wpct_user_has_granular_permission( $user_id, $feature, $action )` – action-level check

## Contributing

Issues and pull requests are welcome. Please:

1. Fork the repository and create a feature branch.
2. Follow [WordPress PHP coding standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/) and keep the `wpct_` function prefix.
3. Escape all output and sanitize and nonce-check all input.
4. Test with a Client account as well as an administrator.
5. Open a pull request describing the change.

## Security

If you find a security issue, please report it privately to the maintainers instead of opening a public issue.

## License

GPL-2.0-or-later, matching the WordPress license. See the `License` header in [wp-client-toolkit.php](wp-client-toolkit.php).

# SystemCps
SystemCps is a user click per second counter system, which also includes a cps limiter, meaning you can configure the cps limit and maximum alerts.
[![](https://poggit.pmmp.io/shield.state/SystemCps)](https://poggit.pmmp.io/p/SystemCps)

# Config
```YAML
# CPS Limit Configuration
cps_limit: 20 # The maximum CPS allowed before a warning is issued

# Warning Settings
max_warnings: 4 # The maximum number of warnings a player can receive before being banned
```

# Form
```YAML
# Form to be sent when the CPS limit is exceeded #
title_warning: "Warning"
content_warning: "It is forbidden to exceed the CPS limit, avoid doing so to avoid being expelled"
```

# Messages
```YAML
msg_kick: "§cYou have been expelled for exceeding the cps limit"
broadcast_msg_kick: "§e{NAME} §cWas expelled for exceeding the cps limit"
```

# Contact
[![Discord Presence](https://lanyard.cnrad.dev/api/1165097093480853634?theme=dark&bg=005cff&animated=false&hideDiscrim=true&borderRadius=30px&idleMessage=Hello)](https://discord.com/users/1165097093480853634)

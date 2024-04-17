

# Phore Template


## Usage


## Template Syntax

- `ifdef` - If the variable is defined
- `ifndef` - If the variable is not defined
- `for` - Loop through the list

```text

# Normal Variable substitution
Hello {{ name }}!

{% ifdef city %}
  Your city is {{ city }}.
{% endif %}

{% ifndef city %}
  Your city is {{ city }}.
{% endif %}

{% for cityList as city %}
  {{ city }}
{% endfor %}

# This is a comment! It will not be included to the output.

{{ name | uppercase }}

{{ dateList | each | uppercase }}

# Example on how to use filter with arguments
{{ curdate | dateFormat format="YYYY-MM-DD" }}

```

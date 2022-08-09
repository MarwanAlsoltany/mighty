<img src="./art/mighty-logo.svg" align="right" width="92" height="92">

# Mighty Validation Expression Language Specification

<p dir="auto">&nbsp;</p>

## Abstract

The Mighty Validation Expression Language is an language that can be used to describe to a Validation Interface (Validator), how data should be validated against a set of validation rules that follow specific guidelines.

This expression language is straightforward, readable, and easy to get along with.
It is a combination of well established and already existing concepts and/or specifications like [Boolean Algebra](https://en.wikipedia.org/wiki/Boolean_algebra), [Bitwise Operators](https://en.wikipedia.org/wiki/Bitwise_operation#Bitwise_operators), [JSON](https://en.wikipedia.org/wiki/JSON), and [CSV](https://en.wikipedia.org/wiki/Comma-separated_values). This makes learning the language a matter of minutes no matter what background the learner has, as long as they have a basic understanding of the concepts.

Validation Expression may be defined as a string that contains some rules separated by **Bitwise Operators** which will build an expression that when evaluated using **Boolean Algebra** logic, will result in the final result of the validation. The rules can have arguments, the types of these arguments can be denoted using the same rules of **JSON** types. A rule can also have multiple arguments and the arguments are separated by commas (**CSV**).

## Overview

This is the Draft for Version `1.0.0` of the Mighty Validation Expression Language. The specification may be updated/changed in the future. The updated version will follow the [Semantic Versioning](https://semver.org/) standard.

The Mighty Validation Expression Language may be referred to for short as "mVEL" (pronounced as **/ɛmːvel/**).

The key words "MUST", "MUST NOT", "SHALL", "SHALL NOT", "SHOULD", "SHOULD NOT", "MAY", "REQUIRED", "RECOMMENDED", and "OPTIONAL" in this document are to be interpreted as described in [RFC 2119](https://datatracker.ietf.org/doc/html/rfc2119) when, and only when, they appear in capital letters.

The characters `,` (comma), `'` (single quote), `~` (tilde), `&` (ampersand), `|` (pipe), and `^` (caret) are RESERVED characters that have special meaning and SHALL NOT be used as part of the rule statement without being escaped and/or enclosed. These characters will be referred to as `LANGUAGE-RESERVED` throughout this document.

---

## Content

  - [1.0.0 Validation Rule](#100-validation-rule)
    - [1.1.0 Validation Rule Name](#110-validation-rule-name)
    - [1.2.0 Validation Rule Arguments](#120-validation-rule-arguments)
      - [1.2.1 Validation Rule Arguments Types](#121-validation-rule-arguments-types)
  - [2.0.0 Validation Operators](#200-validation-operators)
  - [3.0.0 Validation Behaviors](#300-validation-behaviors)
  - [4.0.0 Validation Expression Synopsis](#400-validation-expression-synopsis)
    - [4.1.0 Validation Rule](#410-validation-rule)
    - [4.2.0 Validation Expression](#420-validation-expression)
  - [5.0.0 Validation Expression Examples](#500-validation-expression-examples)
  - [6.0.0 Validation Expression Supplemental Features](#600-validation-expression-supplemental-features)
    - [6.1.0 Aliases](#610-aliases)
    - [6.2.0 Macros](#620-macros)
    - [6.3.0 Back-References](#630-back-references)
  - [7.0.0 Validation Logic](#700-validation-logic)
    - [7.1.0 Practical Validation Example](#710-practical-validation-example)
  - [8.0.0 Recommendations & Conventions](#800-recommendations--conventions)
  - [9.0.0 Considerations](#900-considerations)

---

## 1.0.0 Validation Rule

Validation rule MUST adhere to the requirements described in the upcoming sub-sections.

### 1.1.0 Validation Rule Name

Rule name MAY be any ASCII string consisting of alphanumeric characters, dots, dashes, underscores, and between 2 and 255 characters. This string MUST always start with a letter and MUST always end with a letter or number.

Rule name must match the following regular expression:

```regex
/^[A-Za-z]{1}[A-Za-z0-9._\-]{0,253}[A-Za-z0-9]{1}$/
```

### 1.2.0 Validation Rule Arguments

Rule arguments are OPTIONAL (a rule MAY have zero or more arguments). If a rule has arguments, the arguments MUST be specifed after the `:` (colon) character. The arguments list is a CSV which MUST have `,` (comma) as the separator, `'` (single quote) as the enclosure, and `\` (backslash) as the escape character. Whitespace MAY be used before and after `:` (colon) or `,` (comma) —within the argument list— but it is NOT REQUIRED nor RECOMMENDED.

#### 1.2.1 Validation Rule Arguments Types

Rule arguments MAY be one of the following types:
1. `null`
2. `boolean`
3. `number`
4. `string`
5. `array`
6. `object`

These types follow almost the same rules as in the JSON Standard. The following points describe each data type in more details:

1. `null`: MUST be exactly the same as in JSON (e.g. `null`).
2. `boolean`: MUST be exactly the same as in JSON (e.g. `true`, `false`).
3. `number`: MUST be exactly the same as in JSON (e.g. `1`, `1.23`).
4. `string`: SHOULD be exactly as in JSON (e.g. `"string"`) but MAY be written without the quotes (e.g. `string`) if the argument is a string by its own (not part of an `array` or `object`).
5. `array`: MUST be exactly the same as in JSON (e.g. `[1, "two", {"three": 3}]`).
6. `object`: MUST be exactly the same as in JSON (e.g. `{"key": "value"}`).

Any argument containing any `LANGUAGE-RESERVED` character MUST always be escaped by wrapping it as a whole with `'` (single quote) characters, and any single quotes inside the wrapped argument need to be escaped using the `\` (backslash) character. These augments are mostly strings containing `LANGUAGE-RESERVED` character (e.g. regular expressions), arrays containing more than one item, or objects containing more than one key-value pairs.

---

## 2.0.0 Validation Operators

The Validation Expression MAY contain zero or more of the following operators:

| No. | Token Name | Character | Function |
| -- | -- | -- | -- |
| 1 | **NOT** | `~` (tilde) | Negation |
| 2 | **AND** | `&` (ampersand) | Conjunction |
| 3 | **OR** | `\|` (pipe) | Disjunction |
| 4 | **XOR** | `^` (caret) | Exclusive Disjunction |
| 5 | **OPEN** | `(` (opening parenthesis) | Open |
| 6 | **CLOSE** | `)` (closing parenthesis) | Close |
| 7 | **GROUP** | `(` and `)` pairs (parentheses) | Precedence |

Few notes regarding the operators MUST be taken into account:

* The expression MAY have whitespace surrounding the operator.
* The expression MUST NOT start with an operator like `&`, `|`, `^` or end with an operator like `~`, `&`, `|`, `^`.
* The expression MUST NOT have an operator like `&`, `|`, `^` that is repeated more than once in row.
* The expression MUST always have balanced `(` and `)` parentheses.
* The expression is always evaluated from left to right regardless of the operation. Operations have no precedence by default. Desired precedence MUST be explicitly specifed using parentheses (`(`, `)`).

---

## 3.0.0 Validation Behaviors

The Validation Expression MAY have a behavior. Behaviors are a way to influence the entire expression at once. A behavior is denoted using a single character at the beginning of the expression. The behavior can be any of the following:
1. **NORMAL**: No prefix. Execute all rules. This is the default behavior.
2. **OPTIMISTIC**: `?` (question mark) prefix. Stop executing rules after the first success, the rest of the rules will be considered successful.
3. **PESSIMISTIC**: `!` (exclamation mark) prefix. Stop executing rules after the first failure, the rest of the rules will be considered unsuccessful.

---

<div class="page"/>

## 4.0.0 Validation Expression Synopsis

The following sub-sections will outline the synopses of the Validation Rule and the Validation Expression.

### 4.1.0 Validation Rule

```graphql

                   (*)
                    ╤
                    ├───> (B)
   ┌────────────┬───┴──┬──────────────────┐
 ■ │ {namespace}.{name}:{arg0},{arg1},... ├───> (D)
   └─────┬──────┴──────┴───────────┬──────┘
         ├───> (A)                 ├───> (C)
         ╧                         ╧
        (?)                       (?)

 ● (A) Rule Namespace
 ● (B) Rule Name
 ● (C) Rule Arguments
 ● (D) Rule Statement (A through C)

 ► (*) Required
 ► (?) Optional

```

### 4.2.0 Validation Expression

```graphql

                (*)                 (*/?)
                 ╤                    ╤
                 ├───> (B) <──────────┤
   ┌───────────┬─┴────┬──────────┬────┴─┬──────┐
 ■ │ {behavior} {rule} {operator} {rule} {...} │
   └─────┬─────┴──────┴─────┬────┴──────┴───┬──┘
         ├───> (A)          ├───> (C)       ├───> (D)
         ╧                  ╧               ╧
        (?)               (*/?)            (?)

 ● (A) Validation Behavior
 ● (B) Validation Rule (Rule Statement)
 ● (C) Validation Operator
 ● (D) Repetition of C and B (in the specified order; zero or more)

 ► (*) Required
 ► (?) Optional
 ► (*/?) Required only if previous is not optional

```

---

## 5.0.0 Validation Expression Examples

* `required`: [*there must be a value*] This is the most basic Validation Expression. It consists of a single rule. The final result of this expression is the result of the rule.

* `required&string`: [*there must be a value and the value must be string*] This is an expression that consists of two rules. The result of this expression is the result of **AND**ing the results of each rule.

* `string&between:3,5|null`: [*the value must be string between 3 and 5 characters or null*] This is an expression that consists of three rules. The result of this expression is the result of **AND**ing the results of the first two rules and **OR**ing it with the result of the last rule.

* `scalar|[nullable]`: [*the value must be scalar or nullable*] This is an expression consisting of a rule and a macro. The result of this expression is the result of **OR**ing the results of the two sides. The macro in this case is `(null^~empty)` [*the value must be either null or not empty (some non-empty type)*] (**XOR**).

---

## 6.0.0 Validation Expression Supplemental Features

There SHOULD be the possibility to provide ways to simplify the Validation Expression to increase its readability and to hook into the process. The RECOMMENDED features to implement are (1) the possibility to alias a rule, (2) the possibility create a macro for a set of rules, (3) the possibility to reference any available data in the current context.

### 6.1.0 Aliases

An alias is as simple as a another name for an existing rule. This new name can be used in the same way as the original rule (will inherit all arguments if there is any).

### 6.2.0 Macros

Macros on the other hand are a way to group a set of rules (i.e. sub-expression) that can be referenced/called using the syntax `[macro]` inside the Validation Expression. Macros are used normally to reuse a common or repeated set of rules, or to make the final Validation Expression more compact.

### 6.3.0 Back-References

In the context of validating complex structured-data. There SHOULD also be the possibility to provide a way to hook into the validation process during run-time in such a way that a field can depend on another field's validation result. For this, the concept of Back-References MAY be implemented. This feature is rather more complex than the others but it does open the door for a new tier of rules that leverage conditional logic to build even more complex validations.

A back-reference is simply a way to access any currently available data in the current context resulting from the validation process. This can be anything from the key or the value of another field, the result of the entire validation of some field, or the result of a specific rule of some field. The RECOMMENDED syntax for back-references is `${path.to.some.value}` (similar to JavaScript interpolation notation). Note that the data resulting from the field that is currently being validated can not be accessed at this time, as the validation process is not yet complete, but its value can be retrieved using a special back-reference, that is the `${this}` back-reference, which references the value that is currently being validated. This is useful with rules that do not have anything to do with the input like conditionals (e.g. `if:${this},18,<=`) but sometimes the value may be needed to be compared against something.

An example where back-references can be used is in forms where some field is only required if another field does not satisfy some condition. A practical example for this would be a form that can be submitted by anyone, but if the user is a minor, then a parental consent MUST be provided. Accordingly, the validation for such field can be something like `if.lt:${age.value},18|(required&accepted)` (if age is less than 18, the field is required and must be accepted otherwise it's optional).

---

## 7.0.0 Validation Logic

The implementation of the Parser/Engine and/or Validator MUST be able to parse the combination of Rules, Operators, and Behaviors into a set of tokens that can be checked separately and combined later to build the final validation result. The following steps describe a pseudo implementation of the Parser and the Validator:

1. The Validator SHOULD consist of an interface that takes input and validation as parameters.
2. The Validator SHOULD save a copy of the expression as is to be used later.
3. The Validator MUST detect expression behavior and save a copy of it without the behavior character for a later use.
4. The Parser SHOULD split the expression into a set of rules.
5. The Parser SHOULD parse each rule as *name* and *statement*.
6. The Parser SHOULD parse the statement as *name* and *arguments* (symbol).
7. The Parser MUST convert rule arguments to their expected data types using validation rule definition.
8. The Validator SHOULD execute the parsed statement against the current input.
9. The result of executing the statement SHOULD be returned as a boolean value (if not, it will be casted explicitly).
10. The boolean result of the rule SHOULD be converted to a bit (`0` or `1`) and replace the rule statement in the expression from step 2.
11. If the expression has a behavior other than the NORMAL behavior. The checking SHOULD stop and the statement of each of the remained rules MUST be replaced with the appropriate result (depending on the behavior).
12. If the expression is in NORMAL behavior, the steps 5. through 8. should be repeated for each rule as many times as needed to resolve all rules —including duplicates— in the expression.
13. The final expression by now SHOULD only contain the characters: `0`, `1`, `~`, `&`, `|`, `^`, `(`, `)`.
14. The final expression SHOULD be evaluated as a bitwise expression to determine the final result of the validation.
15. The Validator now can return the result in a structured way, including formatted error messages with all relevant information (key, value, result, validations, errors, and metadata).

> NOTE: The steps listed above are only for demonstration purposes, they give only a general idea of the validation process. The actual validation process is up to the final implementation of the specification as long as it adheres to the general guidelines.

### 7.1.0 Practical Validation Example

Let's take the expression &nbsp;`required & string & between:2,255 | null`&nbsp; —*whitespace is for readability*— as a Validation Expression.

This expression can be understood as the following:

1. There are four rules.
2. The expression contains the rules:
    1. `required`: Asserts that the input is present.
    2. `string`: Asserts that the input is a string.
    3. `between:2,255`: Asserts that the input is between 2 and 255 in length.
    4. `null`: Asserts that the input is null.

The `required&string&between:2,255|null` expression means:

The input must be present; **AND** of type string; **AND** between 2 and 255 in length; **OR** null.
So it's a nullable string that when is not null must be between 2 and 255 characters long.

Lets say the the input was `"Mighty is Awesome!"`, the result of the expression `required&string&between:2,255|null` against that input would be `1&1&1|0` which will result in `1` which is `true`, if the input was `null` the result would be `0&0&0|1` = `1` which is also `true`, if the input was `"X"` the result would be `1&1&0|0` = `0` which is `false`, etc ...

---

## 8.0.0 Recommendations & Conventions

1. Unnecessary whitespace in rule statement SHOULD be eliminated (e.g. `assert : "1", 1, "=="` -> `assert:"1",1,"=="`).
2. Unnecessary whitespace around operators SHOULD be eliminated (e.g. `string & min:3` -> `string&min:3`).
3. Rule names SHOULD be in Camel Case (e.g. `stringContains:substring`).
4. Rules MAY have namespaces (e.g. the `string` namespace). It is RECOMMENDED that the namespace is always kept to a single word in lowercase that prefixes and is separated from rule name with a `.` (dot) (e.g. `string.startsWith:substring`). Namespaces can have as much levels as needed (not exceeding the 255 characters limit including rule name).
5. There SHOULD be a fluent interface that serves as an abstraction to write Validation Expressions. Although Validation Expressions are relatively easy to write and human-readable, they can get complicated pretty quickly, especially when there a lot of arguments that need escaping. The fluent interface will make this a lot easier and also provide IDE-Intellisense which will make the entire process a lot more easier and provide a friendlier user-experience.

---

## 9.0.0 Considerations
* The Validation Expression MUST be in UTF-8 encoding.
* The Validation Expression MUST NOT be an empty string, it must contain at least one rule. Empty Validation Expressions MUST be considered invalid.
* The Validation Expression MAY be used as a processor (backend) for different validation interfaces (frontend), for example: a classical Validator interface, Attributes/Annotations, APIs, etc ...

---

### Author

Name: Marwan Al-Soltany

E-Mail: [MarwanAlsoltany@gmail.com](mailto:MarwanAlsoltany@gmail.com)

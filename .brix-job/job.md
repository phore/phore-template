Add a unittest for this case for ParserKit::ReadUntilToken to support multi-character tokens. So if allowedToken includes "{{" it will not stop on the first "{". 

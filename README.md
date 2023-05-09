# Logger Exercise

### Requirements

- generic and extendable
- different output targets, console (STDOUT) output mandatory
- support for different log levels in the following order
  - debug
  - info
  - warning
  - error
- ability to set minimum log level per output target

# Potential improvements

- tests and documentation, obviously
- add "fingers crossed" capabilities, e.g. log debug entries when error is logged
- add logger registry so multiple loggers with different configurations may be used in context of the same application
- how to handle logs from the inner components? for example if a formatter fails and throws an exception - some kind of anti-loop layer should be defined - maybe checking the logging depth somehow?
- handle exceptions from inside logger (so that failure of one handler doesn't collapse the whole logger)
- add batch (buffered) processing of logs for example when we are sending them via email or external API not to make such a call on each log entry
- add normalizers instead of relying on formatters to normalize the data
- in the LineFormatter, handle newlines and perhaps escape the " character
- handle the whole stacktrace if Throwable given
- forbid duplicates of meta processors
- check for types of $metaProcessors and $outputTargets in the logger class
- define levels in an enum
- locks could be used when writing to streams for improved concurrent handling
- the list could go on and on, there are so many nuances to uncover